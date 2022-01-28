<?php

namespace UIlib\Gumpress;

/**
 * Assets handlers class
 */
class Assets {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_script( 'gumroad-embed', 'https://gumroad.com/js/gumroad.js', false, UL_GUMPRESS_VERSION, false );
        wp_enqueue_script( 'gumpress', UL_GUMPRESS_ASSETS.'/js/gumpress.js', array( 'jquery' ), UL_GUMPRESS_VERSION, true );
        wp_enqueue_style( 'ul-gumpress-style', UL_GUMPRESS_ASSETS.'/css/gumpress.css', false, UL_GUMPRESS_VERSION );
    }


}