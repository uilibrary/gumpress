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
        echo "<a href='$url' class='button product_type_variable add_to_cart_button'>Buy now</a>";
    }

    /**
     * Add Gumroad Buy now button in shop page
     *
     * @param int $a
     * @param object $product
     * @return void
     */
    public function modify_add_to_cart_button($quantity, $product) {
        $url = get_post_meta($product->id, 'gumroad_product_url', true);
        return "<a href='$url' class='gumpress-button button product_type_variable add_to_cart_button'>Buy now</a>";
    }
}
