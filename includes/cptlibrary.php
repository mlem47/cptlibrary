<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
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
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Plugin_Name {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'plugin-name';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cptlibrary-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cptlibrary-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/cptlibrary-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/cptlibrary-public.php';

		$this->loader = new Plugin_Name_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Plugin_Name_i18n();

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

		$plugin_admin = new Plugin_Name_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//register plugin admin menu
		$this->loader->add_action('admin_menu', $plugin_admin, 'cpt_admin_menu');
		//register cpt for import Books
		$this->loader->add_action('init', $plugin_admin, 'cpt_books');
		//register cpt zur Auftragsübersicht
		$this->loader->add_action('init', $plugin_admin, 'cpt_auftrag');
		//register cpt zur Einrichtungsverwaltung
		$this->loader->add_action('init', $plugin_admin, 'cpt_einrichtung');

		//color bg for meta booked in cpt_auftrag
		$this->loader->add_filter('post_class', $plugin_admin, 'cpt_auftrag_color_classes');

		//create custom columns for cpt's
		$this->loader->add_filter('manage_cpt_auftrag_posts_columns', $plugin_admin, 'cpt_set_auftrag_columns');
		$this->loader->add_filter('manage_cpt_books_posts_columns', $plugin_admin, 'cpt_set_books_columns');
		$this->loader->add_filter('manage_cpt_einrichtung_posts_columns', $plugin_admin, 'cpt_set_einrichtung_columns');


		// first number position of execution, second number transmit of cases
		$this->loader->add_action('manage_cpt_auftrag_posts_custom_column', $plugin_admin, 'cpt_custom_auftrag_columns', 10, 8  );
		$this->loader->add_action('manage_cpt_books_posts_custom_column', $plugin_admin, 'cpt_custom_books_columns', 10, 3  );
		$this->loader->add_action('manage_cpt_einrichtung_posts_custom_column', $plugin_admin, 'cpt_custom_einrichtung_columns', 10, 3  );
		
		//trash action if auftrag is trashed
		$this->loader->add_action('wp_trash_post', $plugin_admin, 'trash_cpt_books_status', 1, 1  );


		//meta-boxes for cpt_books
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_books_status');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_books_kennziffer');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_books_autor');

		//meta-box save for cpt_books
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_books_status_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_books_kennziffer_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_books_autor_data');
		
		//meta-boxes for cpt_books
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_einrichtung_email');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_einrichtung_adresse');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_einrichtung_name_sd');
		

		//meta-box save for cpt_books
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_einrichtung_email_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_einrichtung_adresse_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_einrichtung_name_sd_data');
		
		
		//meta-boxes for cpt_auftrag
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_email');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_einrichtung');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_fullname');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_zeitraum');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_zeitraum_end');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_overdue');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_status');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_status_send');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'cpt_auftrag_booksid');

		//meta-box save cpt_auftrag
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_email_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_einrichtung_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_fullname_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_zeitraum_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_zeitraum_end_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_overdue_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_status_data');
		$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_status_send_data');
		//$this->loader->add_action('save_post', $plugin_admin, 'cpt_save_auftrag_booksid_data');


		//cronjob check if overdue
		$this->loader->add_filter('cron_schedules', $plugin_admin, 'cpt_add_cron_interval');
		$this->loader->add_action('cpt_cron_hook', $plugin_admin, 'cpt_auftrag_overdue_check');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Plugin_Name_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );


		//ajax
		$this->loader->add_action( 'wp_ajax_myfilter', $plugin_public, 'cpt_filter_function' ); // wp_ajax_{ACTION HERE} 
		$this->loader->add_action( 'wp_ajax_nopriv_myfilter', $plugin_public, 'cpt_filter_function' );
		
		
		//register shortcodes //mlem
		$this->loader->add_shortcode('cpt_short1', $plugin_public, 'cpt_short1');
		$this->loader->add_shortcode('cpt_short_categories', $plugin_public, 'cpt_short_categories');
		$this->loader->add_shortcode('cpt_short_cat_ajax', $plugin_public, 'cpt_short_cat_ajax');
		$this->loader->add_shortcode('cpt_short_cron1', $plugin_public, 'cpt_short_cron1');
		$this->loader->add_shortcode('cpt_cat_filter', $plugin_public, 'cpt_cat_filter');
		$this->loader->add_shortcode('cpt_display_search_form', $plugin_public, 'cpt_display_search_form');

		//add single-post template for cpt_books //mlem
		$this->loader->add_filter('single_template', $plugin_public, 'load_cpt_books', 50, 1);
		$this->loader->add_filter('single_template', $plugin_public, 'load_cpt_auftrag_checkout', 50, 1);
		$this->loader->add_filter('search_template', $plugin_public, 'search_cpt_books', 50, 1);

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
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
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

}
