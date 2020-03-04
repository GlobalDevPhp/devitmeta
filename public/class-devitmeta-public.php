<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.0
 *
 * @package    Ykimportwoo
 * @subpackage Ykimportwoo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/public
 * @author     Yevgen Khromykh <itnotes.org.ua@gmail.com >
 */
class Devitmeta_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    private $resorce_headclass;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, &$resorce_headclass ) {
        $this->resorce_headclass = $resorce_headclass;
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/devitmeta-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/devitmeta-public.js', array( 'jquery' ), $this->version, false );

	}
    public function render_user_list(array $templates_var){
        require plugin_dir_path( dirname( __FILE__)).'public/partials/devitmeta-public-user-list.php';
    }
    public function render_user_info($userobj){
        require plugin_dir_path( dirname( __FILE__)).'public/partials/devitmeta-public-user-info.php';
    }
    public function devit_users(){
        if ((int)$_GET['user_info'] > 0){
            $this->devit_users_info();
        }
        else{
            $this->devit_users_list();
        }
    }
    // Замена шорткода [devit_users]
    public function devit_users_list(){
        $templates_var = array();
        $user_num_by_page = 10;
        $offset = 0;

        global $paged;
        if ($paged > 0)
            $offset = ($paged - 1)*$user_num_by_page;
        $userscnt = get_users();
        $pagesnum = ceil (count($userscnt)/$user_num_by_page);

        $args = array(
            'number'  =>  $user_num_by_page,
            'offset'   => $offset
        );
        $templates_var['users'] = get_users($args);
        $templates_var['pagination'] = $this->paginate_users($pagesnum);
        $this->render_user_list($templates_var);
    }

    public function devit_users_info(){
        $userobj = get_userdata( (int)$_GET['user_info'] );

        $userobj->genderarr = array('','Пока не определился','Женский','Мужской');
        $userobj->familyarr = array('Чёрт не разберёт','Холост','Женат','Жена, Дети, ипотека','На рыбалке','Замужем','Не замужем','Хочу мороженку');
        list($userobj->meta_adress,$userobj->meta_phone,$userobj->meta_gender,$userobj->meta_family) = $this->resorce_headclass->decode_metadata($userobj->ID);
        $this->render_user_info($userobj);
    }
    // генерируем код паджинации
    private function paginate_users($numuser){
        $total = isset( $numuser ) ? $numuser : 1;
        $a['total'] = $total;
        $a['mid_size'] = 3; // сколько ссылок показывать слева и справа от текущей
        $a['end_size'] = 1; // сколько ссылок показывать в начале и в конце
        $a['prev_text'] = '&laquo;'; // текст ссылки "Предыдущая страница"
        $a['next_text'] = '&raquo;'; // текст ссылки "Следующая страница"
        $result = "";
        if ( $total > 1 ) $result .= '<nav class="pagination">';
        $result .= paginate_links( $a );
        if ( $total > 1 ) $result .= '</nav>';
        return $result;
    }

}
