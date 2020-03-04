<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.0
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 * @author     Yevgen Khromykh <itnotes.org.ua@gmail.com >
 */
class Devitmeta {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      Devitmeta_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
    /**
     * @var     string     $plugin_path   path to root plugin files devitmeta
     */
	public $plugin_path;

	public $private_key;
    public $public_key;
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DEVITMETA_VERSION' ) ) {
			$this->version = DEVITMETA_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->plugin_name = 'devitmeta';

		$this->load_dependencies();
		$this->set_locale();
		if (is_admin()){
		    $this->define_admin_hooks();
		}
		$page_id = get_option('devitmeta_post_id');

        $this->define_public_hooks();

		$this->public_key = get_option('devitmeta_public_key');
        $this->private_key = get_option('devitmeta_private_key');
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Devitmeta_Loader. Orchestrates the hooks of the plugin.
	 * - Devitmeta_i18n. Defines internationalization functionality.
	 * - Devitmeta_Admin. Defines all hooks for the admin area.
	 * - Devitmeta_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-devitmeta-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-devitmeta-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-devitmeta-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-devitmeta-public.php';

		$this->loader = new Devitmeta_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Devitmeta_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Devitmeta_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Devitmeta_Admin( $this->get_plugin_name(), $this->get_version(), $this );
// хук для страницы своего профиля, дополняем её
        $this->loader->add_action( 'show_user_profile', $plugin_admin,'new_fields_add', 'show');
// хук для страницы редактирования чужого профиля, дополняем её
        $this->loader->add_action( 'edit_user_profile', $plugin_admin,'new_fields_add', 'edit');
// хук для страницы добавления пользователя, дополняем её
        $this->loader->add_action( 'user_new_form', $plugin_admin,'new_fields_add', 'new');

// Хуки сохранения данных
        $this->loader->add_action( 'personal_options_update', $plugin_admin,'new_fields_update');
        $this->loader->add_action( 'edit_user_profile_update', $plugin_admin,'new_fields_update');
        $this->loader->add_action( 'user_register', $plugin_admin,'new_fields_update' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Devitmeta_Public( $this->get_plugin_name(), $this->get_version(),$this );
        add_shortcode('devit_users', array($plugin_public, 'devit_users'));
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Devitmeta_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

    public function decode_metadata($uid){
        $uid = (int)$uid;
        $dvpkadress = get_user_meta( $uid, "adress", 1 );
        $dvpkphone = get_user_meta( $uid, "phone", 1 );
        $dvpkgender = get_user_meta( $uid, "gender", 1 );
        $dvpkfamily = get_user_meta( $uid, "family", 1 );
        $pk = openssl_get_privatekey($this->private_key);
        if ( ! empty($dvpkadress))  openssl_private_decrypt(base64_decode($dvpkadress), $dvadress, $pk);
        if ( ! empty($dvpkphone)) openssl_private_decrypt(base64_decode($dvpkphone), $dvphone, $pk);
        if ( ! empty($dvpkgender)) openssl_private_decrypt(base64_decode($dvpkgender), $dvgender, $pk);
        if ( ! empty($dvpkfamily)) openssl_private_decrypt(base64_decode($dvpkfamily), $dvfamily, $pk);
        return array(wp_unslash($dvadress),wp_unslash($dvphone),(int)$dvgender,(int)$dvfamily);
    }


}
