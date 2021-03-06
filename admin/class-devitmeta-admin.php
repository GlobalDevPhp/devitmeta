<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.1
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/admin
 * @author     Yevgen Khromykh <itnotes.org.ua@gmail.com >
 */
class Devitmeta_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.1
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.1
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    private $resorce_headclass;

    private $adress_field,$phone_field,$gender_field,$family_field;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.1
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version, &$resorce_headclass ) {
        $this->resorce_headclass = $resorce_headclass;
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function render(){
        require plugin_dir_path( dirname( __FILE__)).'admin/partials/devitmeta-admin-display.php';
    }
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.1
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Devitmeta_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Devitmeta_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/devitmeta-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.1
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Devitmeta_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Devitmeta_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/devitmeta-admin.js', array( 'jquery' ), $this->version, false );
    }

    public function new_fields_add($kwhere){
        if ($kwhere != "add-new-user"){
            list($this->adress_field,$this->phone_field,$this->gender_field,$this->family_field) = $this->resorce_headclass->decode_metadata($kwhere->ID);
        }
        $this->render();
    }

    // обновление данных в базе
    public function new_fields_update($kwhere){
        $pk  = openssl_get_publickey($this->resorce_headclass->public_key);
        openssl_public_encrypt(sanitize_text_field(esc_html($_POST['adress'])), $pkadress, $pk);
        openssl_public_encrypt(sanitize_text_field(esc_html($_POST['phone'])), $pkphone, $pk);
        openssl_public_encrypt((int)$_POST['gender'], $pkgender, $pk);
        openssl_public_encrypt((int)$_POST['family'] , $pkfamily, $pk);

        update_user_meta( $kwhere, "adress", base64_encode($pkadress));
        update_user_meta( $kwhere, "phone", base64_encode($pkphone));
        update_user_meta( $kwhere, "gender", base64_encode($pkgender));
        update_user_meta( $kwhere, "family", base64_encode($pkfamily));
    }


}
