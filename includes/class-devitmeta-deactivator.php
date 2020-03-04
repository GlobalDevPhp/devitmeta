<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.1
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.1
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 * @author     Yevgen Khromykh <itnotes.org.ua@gmail.com >
 */
class Devitmeta_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        delete_option('devitmeta_private_key');
        delete_option('devitmeta_public_key');
        $post_id = get_option( 'devitmeta_post_id');
        if ($post_id)
            wp_delete_post( $post_id, true );
        delete_option('devitmeta_post_id');
	}

}
