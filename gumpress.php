<?php

/**
 * Plugin Name: Gumpress
 * Description: Sell Gumroad product on WooCommerce
 * Plugin URI: https://ui-lib.com/gumpress
 * Author: UI Lib
 * Author URI: https://ui-lib.com
 * Version: 1.0.1
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: uilib-gumpress
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Gumpress {

    /**
     * Plugin version
     *
    * @var string
     */
    const version = '1.0';

    /**
     * Class construcotr
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Gumpress
     */
    public static function init() {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define('UL_GUMPRESS_VERSION', self::version);
        define('UL_GUMPRESS_FILE', __FILE__);
        define('UL_GUMPRESS_PATH', __DIR__);
        define('UL_GUMPRESS_URL', plugins_url('', UL_GUMPRESS_FILE));
        define('UL_GUMPRESS_ASSETS', UL_GUMPRESS_URL . '/assets');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new UIlib\Gumpress\Assets();

        if (is_admin()) {
            new \UIlib\Gumpress\Admin();
        } else {
            // wp_die(';fjdlskfl');
            new \UIlib\Gumpress\Frontend();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new \UIlib\Gumpress\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Gumpress
 */
function gumpress() {
    return Gumpress::init();
}

gumpress();

