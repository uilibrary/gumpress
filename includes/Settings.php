<?php

namespace UIlib\Gumpress;

use UIlib\Gumpress\Admin\Product;

class Settings {

    /**
     * Initialize the class
     */
    function __construct() {
    }
    /**
     * Render settings page
     */
    public function settings_page() {
        if ( ! is_woocommerce_activated() ) {
            $message = __('Please install and activate Woocommerce first.', 'uilib-gumpress');
            echo "<div class='notice notice-error'>
                <p>{$message}</p>
            </div>";
            return;
        }

        include __DIR__ . '/Admin/views/settings.php';

        $action = isset( $_GET['action'] );

        if ( $action == 'sync' ) {
            $this->sync_products();
        }
    }

    /**
     * Handles Gumroad api form
     *
     * @return void
     */
    public function form_handler() {
        if ( ! isset( $_POST['save_gumroad_http_token'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'gumroad-http-token' ) ) {
            wp_die( 'Validation error!' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Validation error!' );
        }

        $token = isset( $_POST['gumroad-http-token'] ) ? sanitize_text_field( $_POST['gumroad-http-token'] ) : '';
        $reset_description = isset( $_POST['gp-reset-description']);
        $reset_title = isset( $_POST['gp-reset-title']);

        update_option('gumroad_http_token', $token);
        update_option('gp_reset_description', $reset_description);
        update_option('gp_reset_title', $reset_title);

        $redirected_to = admin_url( 'admin.php?page=uilib-gumpress&saved=true' );

        wp_redirect( $redirected_to );
        exit;
    }

    /**
     * Sync Woocommerce products with Gumroad products
     *
     * @return void
     */
    public function sync_products() {
        $product        = new Product();
        $gumroad        = new Gumroad();
        $product_list   = $gumroad->get_published_product_list();

        if ( is_wp_error( $product_list ) ) {
            echo "<div class='notice notice-error'>
                <p>{$product_list->get_error_message()}</p>
            </div>";
            return;
        }

        foreach ( $product_list as $key => $gumroad_product ) {
            $variants            = [];
            $is_variable_product = $gumroad_product['variants'][0] ? true : false;
            $is_updated = false;

            if($is_variable_product) {
                $variants = $gumroad_product['variants'][0]['options'];
            }

            $gumroad_product_id     = $gumroad_product['id'];
            $gumroad_relationship   = get_gumroad_relationship( $gumroad_product_id );
            $base_price             = $gumroad_product['price'];
            $woo_product_exists     = false;

            if ( $gumroad_relationship ) {
                $woo_product_exists = get_post_status( $gumroad_relationship->product_id ) == 'publish';
            }

            // IF RELATIONSHIP DOES NOT EXISTS
            if ( ! $gumroad_relationship ) {
                // CREATE WOO PRODUCT
                $woo_product_id = $product->create_product( $gumroad_product );

                // CREATE PRODUCT VARIATIONS
                if( $is_variable_product ) {
                    ul_create_product_variation( $woo_product_id, [
                        'base_price'    => $base_price,
                        'variants'      => $variants,
                    ]);
                }

                // CREATE RELATIONSHIP
                ul_update_gumroad_relationship([
                    'product_id'            => $woo_product_id,
                    'gumroad_product_id'    => $gumroad_product['id'],
                ]);

            // RELATIONSHIP EXITS BUT WOO PRODUCT DOES NOT EXISTS
            } elseif ( $gumroad_relationship && ! $woo_product_exists ) {
                // CREATE WOO PRODUCT
                $woo_product_id = $product->create_product( $gumroad_product );

                // CREATE PRODUCT VARIATIONS
                if($is_variable_product) {
                    ul_create_product_variation( $woo_product_id, [
                        'base_price'    => $gumroad_product['price'],
                        'variants'      => $variants,
                    ], true);
                }

                // UPDATE RELATIONSHIP
                ul_update_gumroad_relationship([
                    'id'                    => $gumroad_relationship->id,
                    'product_id'            => $woo_product_id,
                    'gumroad_product_id'    => $gumroad_product['id'],
                ]);

            } elseif( $gumroad_relationship && $woo_product_exists ) {

                // UPDATE WOO PRODUCT
                $woo_product_id = $product->update_product(
                    $gumroad_relationship->product_id,
                    $gumroad_product
                );

                // UPDATE PRODUCT VARIATIONS
                if($is_variable_product) {
                    ul_create_product_variation( $woo_product_id, [
                        'base_price'    => $gumroad_product['price'],
                        'variants'      => $variants,
                    ], true);
                }
                $is_updated = true;
            }

            // SHOW UPDATED/IMPORTED MESSAGE
            $update_message = $is_updated ? __('Updated', 'uilib-gumpress') : __('Imported', 'uilib-gumpress');
            echo wp_sprintf('<p> %s - <span style="color: var(--wc-highlight)">%s</span></p>', esc_html($gumroad_product['name']), $update_message);

            // SHOW PRODUCTS PAGE LINK
            end($product_list);
            $last_key = key($product_list);
            if ( $key === $last_key ) {
                $admin_products_page = admin_url('edit.php?post_type=product');
                echo wp_sprintf('<p>Done! Check out <a href="%s">%s</a></p>', esc_url($admin_products_page), __('Products page', 'uilib-gumpress'));
            }
        }
    }
}
