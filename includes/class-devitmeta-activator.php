<?php

/**
 * Fired during plugin activation
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.1
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 * @author     Yevgen Khromykh <itnotes.org.ua@gmail.com >
 */
class Devitmeta_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        static::gen_rsa_key();
        static::create_page();

    }
    private static function gen_rsa_key(){
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);
        add_option( 'devitmeta_private_key', $privKey, '', 'yes' );
        // Extract the public key from $res to $pubKey
        $pubKey_array = openssl_pkey_get_details($res);
        $pubKey = $pubKey_array["key"];
        add_option( 'devitmeta_public_key', $pubKey, '', 'yes' );
    }

    private static function create_page(){
        global $user_ID;
        $new_page_title = 'test_devit_meta';
        $new_page_content = '[devit_users]';

        $page_check = get_page_by_title($new_page_title);
        $new_page = array(
            'post_type' => 'page',
            'post_title' => $new_page_title,
            'post_content' => $new_page_content,
            'post_status' => 'publish',
            'post_author' => $user_ID,
        );
        if(!isset($page_check->ID)){
            $new_page_id = wp_insert_post($new_page);
            add_option( 'devitmeta_post_id', $new_page_id, '', 'yes' );
        }
    }
}
