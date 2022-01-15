<?php

namespace UIlib\Gumpress;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    function __construct() {
        $settings = new Settings();
        $this->dispatch_actions( $settings );
        new Admin\Menu( $settings );
    }

    /**
     * Dispatch and bind actions
     * @param object $settings | Instance of Settings
     * @return void
     */
    public function dispatch_actions( $settings ) {
        add_action( 'admin_init', [ $settings, 'form_handler' ] );
    }
}