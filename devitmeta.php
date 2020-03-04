<?php
/*
Plugin Name: devitmeta
Plugin URI: http://www.itnotes.org.ua/
Description: This plugin add metafields to users profile, and create page test_devit_meta.
Author: Yevgen Khromykh <xevxevx@gmail.com>
Contributor: Yevgen Khromykh <xevxevx@gmail.com>
Author URI: http://www.itnotes.org.ua/
Version: 0.1
*/
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DEVITMETA_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ykimportwoo-activator.php
 */
function activate_devitmeta() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-devitmeta-activator.php';
    Devitmeta_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ykimportwoo-deactivator.php
 */
function deactivate_devitmeta() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-devitmeta-deactivator.php';
    Devitmeta_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_devitmeta' );
register_deactivation_hook( __FILE__, 'deactivate_devitmeta' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-devitmeta.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_devitmeta() {

    $plugin = new Devitmeta();
    $plugin->plugin_path  = dirname( __FILE__ );
    $plugin->run();

}
add_action('init','run_devitmeta');
?>