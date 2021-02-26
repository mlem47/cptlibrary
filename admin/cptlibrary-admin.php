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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cptlibrary-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );

	}

	public function cpt_admin_menu(){
		add_menu_page( 'Admin','Ausleihe', 'manage_options', 'cpt_admin', array($this, 'myplugin_admin_page'),'dashicons-cpt_books' );
		add_submenu_page( 'cpt_admin', 'Buchimport', 'Buecher', 'manage_options', 'edit.php?post_type=cpt_books' );
		add_submenu_page( 'cpt_admin', 'Auftrag', 'Auftrag', 'manage_options', 'edit.php?post_type=cpt_auftrag' );
		add_submenu_page( 'cpt_admin', 'Einrichtung', 'Einrichtungen', 'manage_options', 'edit.php?post_type=cpt_einrichtung' );
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cptlibrary-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-js', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-js', plugin_dir_url( __FILE__ ) . 'js/jquery.js', array( 'jquery' ), $this->version, false );

	}


  


//this function creates our cpt_bookspimport post type cpt_books //mlem
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
	   'rewrite' 			 => array( 'slug' => 'cpt_books'),
	   // Features this CPT supports in Post Editor
	   'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
	   // You can associate this CPT with a taxonomy or custom taxonomy. 
	   'taxonomies'          => array( 'ISBN' , 'Kennziffer', 'ISBN'),
	   /* A hierarchical CPT is like Pages and can have
	   * Parent and child items. A non-hierarchical CPT
	   * is like Posts.
	   */ 
	   'hierarchical'        => false,
	   'public'              => true,
	   'description' 		  => '',
	   'show_ui'             => true,
	   'show_in_menu'        => 'edit.php?post_type=cpt_books',
	   'show_in_nav_menus'   => true,
	   'show_in_admin_bar'   => true,
	   'menu_position'       => 5,
	   'menu_icon' 		 	 => 'dashicons-book',
	   'can_export'          => false,
	   'has_archive'         => true,
	   'exclude_from_search' => false,
	   'publicly_queryable'  => true,
	   'capability_type'     => 'post',
	   'show_in_rest' 		=> true,
   );
   
	// Registering your Custom Post Type
	register_post_type( 'cpt_books', $args );
	
	
	}

	//register taxonomies for cpt_bookss, Magazines

	public function cptlib_tax_books() {

		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Kennziffer', 'taxonomy general name'),
			'singular_name'              => _x( 'Kennziffer', 'taxonomy singular name'),
			'search_items'               => __( 'Search Kennziffer'),
			'popular_items'              => __( 'Popular Kennziffer'),
			'all_items'                  => __( 'All Kennziffer'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Kennziffer'),
			'update_item'                => __( 'Update Kennziffer'),
			'add_new_item'               => __( 'Add New Kennziffer'),
			'new_item_name'              => __( 'New Kennziffer Name'),
			'separate_items_with_commas' => __( 'Separate Kennziffer with commas'),
			'add_or_remove_items'        => __( 'Add or remove Kennziffer'),
			'choose_from_most_used'      => __( 'Choose from the most used Kennziffer'),
			'not_found'                  => __( 'No Kennziffer found.'),
			'menu_name'                  => __( 'Kennziffer'),
		);
	 
		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'Kennziffer' ),
			
		);
		
	 
		register_taxonomy( 'Kennziffer', 'cpt_books', $args );
		
	 
		unset( $args );
		unset( $labels );
	 
		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'              => _x( 'Autor', 'taxonomy general name'),
			'singular_name'     => _x( 'Autor', 'taxonomy singular name'),
			'search_items'      => __( 'Search Autor'),
			'all_items'         => __( 'All Autor'),
			'parent_item'       => __( 'Parent Autor'),
			'parent_item_colon' => __( 'Parent Autor:'),
			'edit_item'         => __( 'Edit Autor'),
			'update_item'       => __( 'Update Autor'),
			'add_new_item'      => __( 'Add New Autor'),
			'new_item_name'     => __( 'New Autor Name'),
			'menu_name'         => __( 'Autor'),
		);
	 
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'Autor' ),
		);
	 
		register_taxonomy( 'Autor', 'cpt_books', $args );

		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'ISBN', 'taxonomy general name'),
			'singular_name'     => _x( 'ISBN', 'taxonomy singular name'),
			'search_items'      => __( 'Search ISBN'),
			'all_items'         => __( 'All ISBN'),
			'parent_item'       => __( 'Parent ISBN'),
			'parent_item_colon' => __( 'Parent ISBN:'),
			'edit_item'         => __( 'Edit ISBN'),
			'update_item'       => __( 'Update ISBN'),
			'add_new_item'      => __( 'Add New ISBN'),
			'new_item_name'     => __( 'New ISBN Name'),
			'menu_name'         => __( 'ISBN'),
		);
	 
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'ISBN' ),
		);
	 
		register_taxonomy( 'ISBN', array( 'cpt_books' ), $args );
	}

   //register Auftrags CPT

   //this function creates our cpt_bookspimport post type cpt_books //mlem
	public function cpt_auftrag(){
	/*
	* Creating a function to create our CPT
		*/
		$labels = array(
			'name'                => _x( 'Auftrag', 'Post Type General Name'),
			'singular_name'       => _x( 'Auftrag', 'Post Type Singular Name'),
			'menu_name'           => __( 'Auftragsannahme'),
			'parent_item_colon'   => __( 'Parent Video'),
			'all_items'           => __( 'Alle Auftraege'),
			'view_item'           => __( 'Alle Auftraege'),
			'add_new_item'        => __( 'Neuer Auftrag'),
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
		'label'               => __( 'cpt_auftrag'),
		'description'         => __( 'Buchimporte'),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'ISBN' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/ 
		'hierarchical'        => false,
		'public'              => true,
		'description' 		  => '',
		'taxonomies' 		  => array(),
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php?post_type=cpt_auftrag',
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
	register_post_type( 'cpt_auftrag', $args );
	}
	

   //register Einrichtung CPT 

   //this function creates our cpt_bookspimport post type cpt_books //mlem
	public function cpt_einrichtung(){
	/*
	* Creating a function to create our CPT
		*/
		$labels = array(
			'name'                => _x( 'Einrichtung', 'Post Type General Name'),
			'singular_name'       => _x( 'Einrichtung', 'Post Type Singular Name'),
			'menu_name'           => __( 'Einrichtung hinzufügen'),
			'parent_item_colon'   => __( 'Parent Video'),
			'all_items'           => __( 'Alle Einrichtungen'),
			'view_item'           => __( 'Alle Einrichtungen'),
			'add_new_item'        => __( 'Neue Einrichtung'),
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
		'label'               => __( 'cpt_einrichtung'),
		'description'         => __( 'Buchimporte'),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/ 
		'hierarchical'        => false,
		'public'              => true,
		'taxonomies' 		  => array(),
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php?post_type=cpt_einrichtung',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon' 		  => 'dashicons-book',
		'can_export'          => false,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'	 	  => true,
	);
	
	// Registering your Custom Post Type
	register_post_type( 'cpt_einrichtung', $args );
	}

	 //register taxonomies for cpt_einrichtung, Magazines
 
	 public function cptlib_tax_einrichtung() {
		 // Add new taxonomy, make it hierarchical (like categories)
		 $labels = array(
			 'name'              => _x( 'Adresse', 'taxonomy general name'),
			 'singular_name'     => _x( 'Adresse', 'taxonomy singular name'),
			 'search_items'      => __( 'Search Adresse'),
			 'all_items'         => __( 'All Adresse'),
			 'parent_item'       => __( 'Parent Adresse'),
			 'parent_item_colon' => __( 'Parent Adresse:'),
			 'edit_item'         => __( 'Edit Adresse'),
			 'update_item'       => __( 'Update Adresse'),
			 'add_new_item'      => __( 'Add New Adresse'),
			 'new_item_name'     => __( 'New Adresse Name'),
			 'menu_name'         => __( 'Adresse'),
		 );
	  
		 $args = array(
			 'hierarchical'      => true,
			 'labels'            => $labels,
			 'show_ui'           => true,
			 'show_admin_column' => true,
			 'query_var'         => true,
			 'rewrite'           => array( 'slug' => 'Adresse' ),
		 );
	  
		 register_taxonomy( 'Adresse', array( 'cpt_einrichtung' ), $args );
	  
		 unset( $args );
		 unset( $labels );

		 // Add new taxonomy, make it hierarchical (like categories)
		 $labels = array(
			 'name'              => _x( 'PLZ', 'taxonomy general name'),
			 'singular_name'     => _x( 'PLZ', 'taxonomy singular name'),
			 'search_items'      => __( 'Search PLZ'),
			 'all_items'         => __( 'All PLZ'),
			 'parent_item'       => __( 'Parent PLZ'),
			 'parent_item_colon' => __( 'Parent PLZ:'),
			 'edit_item'         => __( 'Edit PLZ'),
			 'update_item'       => __( 'Update PLZ'),
			 'add_new_item'      => __( 'Add New PLZ'),
			 'new_item_name'     => __( 'New PLZ Name'),
			 'menu_name'         => __( 'PLZ'),
		 );
	  
		 $args = array(
			 'hierarchical'      => true,
			 'labels'            => $labels,
			 'show_ui'           => true,
			 'show_admin_column' => true,
			 'query_var'         => true,
			 'rewrite'           => array( 'slug' => 'PLZ' ),
		 );
	  
		 register_taxonomy( 'PLZ', array( 'cpt_einrichtung' ), $args );
	  
		 unset( $args );
		 unset( $labels );

		 // Add new taxonomy, make it hierarchical (like categories)
		 $labels = array(
			 'name'              => _x( 'GL', 'taxonomy general name'),
			 'singular_name'     => _x( 'GL', 'taxonomy singular name'),
			 'search_items'      => __( 'Search GL'),
			 'all_items'         => __( 'All GL'),
			 'parent_item'       => __( 'Parent GL'),
			 'parent_item_colon' => __( 'Parent GL:'),
			 'edit_item'         => __( 'Edit GL'),
			 'update_item'       => __( 'Update GL'),
			 'add_new_item'      => __( 'Add New GL'),
			 'new_item_name'     => __( 'New GL Name'),
			 'menu_name'         => __( 'GL'),
		 );
	  
		 $args = array(
			 'hierarchical'      => true,
			 'labels'            => $labels,
			 'show_ui'           => true,
			 'show_admin_column' => true,
			 'query_var'         => true,
			 'rewrite'           => array( 'slug' => 'GL' ),
		 );
	  
		 register_taxonomy( 'GL', array( 'cpt_einrichtung' ), $args );
	  
	 }

}
