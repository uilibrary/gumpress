<?php

namespace UIlib\Gumpress\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $settings;
    /**
     * Initialize the class
     */
    function __construct($settings) {
        $this->settings = $settings;
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {

        $parent_slug = 'uilib-gumpress';
        $capability = 'manage_options';

        add_menu_page( __( 'Gumpress', 'gumpress' ), __( 'Gumpress', 'gumpress' ), $capability, $parent_slug, [ $this->settings, 'settings_page' ], 'dashicons-vault' );
    }


}