<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Admin {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	public function cpt_admin_menu(){
		add_menu_page( 'Admin','Einstellungen', 'manage_options', 'cpt_einstellungen', array($this, 'myplugin_admin_page'),'dashicons-book' );
		add_submenu_page( 'cpt_einstellungen', 'Buchimport', 'Import', 'manage_options', 'edit.php?post_type=cpt_books' );
		}


	public function myplugin_admin_page(){
		//return page 
			require_once 'partials/cptlibrary-admin-display.php';
		}

		
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}


  


//this function creates our bookpimport post type cpt_books //mlem
public function cpt_books(){
   /*
   * Creating a function to create our CPT
	   */
	   $labels = array(
		   'name'                => _x( 'Buecher', 'Post Type General Name'),
		   'singular_name'       => _x( 'Buch', 'Post Type Singular Name'),
		   'menu_name'           => __( 'Buchimport'),
		   'parent_item_colon'   => __( 'Parent Video'),
		   'all_items'           => __( 'Alle Bücher'),
		   'view_item'           => __( 'Alle Bücher'),
		   'add_new_item'        => __( 'Neuer Artikel'),
		   'add_new'             => __( 'Neu Hinzufügen'),
		   'edit_item'           => __( 'Edit'),
		   'update_item'         => __( 'Update'),
		   'search_items'        => __( 'Suche'),
		   'not_found'           => __( 'Not Found'),
		   'not_found_in_trash'  => __( 'Not found in Trash'),
	   );

   // Set other options for Custom Post Type
   //https://developer.wordpress.org/reference/functions/register_post_type/
	   
   $args = array(
	   'label'               => __( 'cpt_books'),
	   'description'         => __( 'Buchimporte'),
	   'labels'              => $labels,
	   // Features this CPT supports in Post Editor
	   'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
	   // You can associate this CPT with a taxonomy or custom taxonomy. 
	   'taxonomies'          => array( 'genre' ),
	   /* A hierarchical CPT is like Pages and can have
	   * Parent and child items. A non-hierarchical CPT
	   * is like Posts.
	   */ 
	   'hierarchical'        => false,
	   'public'              => true,
	   'description' 		  => '',
	   'supports' 			  => array('title', 'editor', 'thumbnail', 'trackbacks'),
	   'taxonomies' 		  => array('category'),
	   'show_ui'             => true,
	   'show_in_menu'        => 'edit.php?post_type=cpt_books',
	   'show_in_nav_menus'   => true,
	   'show_in_admin_bar'   => true,
	   'menu_position'       => 5,
	   'menu_icon' 		  => 'dashicons-book',
	   'can_export'          => false,
	   'has_archive'         => true,
	   'exclude_from_search' => false,
	   'publicly_queryable'  => true,
	   'capability_type'     => 'post',
	   'show_in_rest' => true,
   );
   
   // Registering your Custom Post Type
   register_post_type( 'cpt_books', $args );
   }
	

}
