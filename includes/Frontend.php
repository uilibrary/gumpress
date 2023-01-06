<?php

namespace UIlib\Gumpress;

/**
 * The Frontend class
 */
class Frontend {

    /**
     * Initialize the class
     */
    function __construct() {
        add_filter( 'woocommerce_loop_add_to_cart_link', [$this, 'modify_add_to_cart_button'], 10, 2 );
        add_filter( 'woocommerce_before_add_to_cart_button', [$this, 'woocommerce_before_add_to_cart_button_callback'], 10, 0 );
    }

    /**
     * Add Gumroad buy now button in single product page
     *
     * @return void
     */
    public function woocommerce_before_add_to_cart_button_callback() {
        $url = get_post_meta(get_the_ID(), 'gumroad_product_url', true);
        echo '<a href="' . esc_url($url) . '" data-gumroad-overlay-checkout="true" class="gumpress-button button add_to_cart_button">' . __('Buy now', 'uilib-gumpress') . '</a>';
    }

    /**
     * Add Gumroad Buy now button in shop page
     *
     * @param int $a
     * @param object $product
     * @return void
     */
    public function modify_add_to_cart_button($quantity, $product) {
        if ( $product->is_type('variable') ) {
            $url = $product->get_permalink();
            return '<a href="' . esc_url($url) . '" class="gumpress-button button add_to_cart_button">' . __('Select options', 'uilib-gumpress') . '</a>';
        } else {
            $url = get_post_meta($product->id, 'gumroad_product_url', true);
            return '<a href="' . esc_url($url) . '" class="gumpress-button button add_to_cart_button">' . __('Buy now', 'uilib-gumpress') . '</a>';

        }


    }
}
