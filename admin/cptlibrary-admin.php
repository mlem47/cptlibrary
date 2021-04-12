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
		wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

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
		wp_enqueue_script( 'jquery-js', plugin_dir_url( __FILE__ ) . 'js/jquery.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-js', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
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
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'category'),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'ISBN' , 'Kennziffer', 'ISBN', 'category'),
		'hierarchical'        => false,
		'public'              => true,
		'description' 		 => '',
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
		'show_in_rest' 		 => true,
	);
	
		// Registering your Custom Post Type
		register_post_type( 'cpt_books', $args );
		
		
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
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
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


	

	//set COLUMNS for cpt_books

	function cpt_set_books_columns($newColumns){
		$newColumns = array();
		$newColumns['cb'] = 'Select';
		$newColumns['title'] = 'Buch';
		$newColumns['buchautor'] = 'Autor';
		$newColumns['kennziffer'] = 'Kennziffer';
		$newColumns['categories'] = 'Kategorie';
		$newColumns['status'] = 'Ausgeliehen';
		$newColumns['date'] = 'Datum';		
		return $newColumns;
	
	}


	function cpt_custom_books_columns($column, $post_id){
		
		switch ($column){

			case 'kennziffer' ;
				$kennziffer = get_post_meta($post_id,'_cpt_books_kennzifferdata_key', true);
				echo $kennziffer;
			break;

			case 'buchautor' ;
				//$buchautor =;
				//echo $buchautor;
			break;

			case 'status' ;
				$status = get_post_meta($post_id,'_cpt_books_statusdata_key', true);
				?>		<input type="checkbox" <?php checked(esc_attr($status), true, true); ?> >    	<?php
			break;

		}
	}
	

	// META BOX for cpt_books Kennziffer

	function cpt_books_kennziffer(){
		add_meta_box( 'books_kennziffer', 'Kennziffer', array($this, 'books_kennziffer_callback'), 'cpt_books', 'side');
	}

	function books_kennziffer_callback($post){
		wp_nonce_field( 'cpt_save_books_kennziffer_data', 'cpt_books_kennzifferdata_meta_box_nonce');
	
		$value = get_post_meta($post->ID, '_cpt_books_kennzifferdata_key', true);	

		echo '<label for="cpt_books_kennzifferdata_field"> Kennziffer: </label>';
		echo '<input type="text" id="cpt_books_kennzifferdata_field" name="cpt_books_kennzifferdata_field" value="' . esc_attr($value) . '" size= "25" />';
	}

	function cpt_save_books_kennziffer_data ($post_id){

		if( ! isset($_POST['cpt_books_kennzifferdata_meta_box_nonce'])){
			
			return;
		
			}

			if( ! wp_verify_nonce($_POST['cpt_books_kennzifferdata_meta_box_nonce'], 'cpt_save_books_kennziffer_data')){
				
				return;
			}
			
			if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return;
			}

			if(! current_user_can ('edit_post', $post_id)){
				
				return;
			}

			if(! isset( $_POST['cpt_books_kennzifferdata_field'])){
				
				return;
			}
			
			$my_data = sanitize_text_field( $_POST['cpt_books_kennzifferdata_field'] );

			update_post_meta( $post_id, '_cpt_books_kennzifferdata_key', $my_data );

	}

	//META BOX cpt_books - Transmit Status


	function cpt_books_status(){
		add_meta_box( 'books_status', 'Status', array($this, 'books_status_callback'), 'cpt_books', 'side');
	}

	function books_status_callback($post){
		wp_nonce_field( 'cpt_save_books_status_data', 'cpt_books_statusdata_meta_box_nonce');
	
		$value = get_post_meta($post->ID, '_cpt_books_statusdata_key', true);	
		?>
		<label for="cpt_books_statusdata_field">Ausgeliehen</label>
		<input type="checkbox" id="cpt_books_statusdata_field" name="cpt_books_statusdata_field" <?php if( $value == true ) { ?>checked="checked"<?php } ?> />
		<?php
	}

	function cpt_save_books_status_data ($post_id){

		if( ! isset($_POST['cpt_books_statusdata_meta_box_nonce'])){
			return;
			echo "POST ERROR";
			}

			if( ! wp_verify_nonce($_POST['cpt_books_statusdata_meta_box_nonce'], 'cpt_save_books_status_data')){
				echo "POST1ERROR";
				return;
			}
			
			if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				echo "POST2 ERROR";
				return;
			}

			if(! current_user_can ('edit_post', $post_id)){
				echo "POST3 ERROR";
				return;
			}

			$my_data = isset( $_POST['cpt_books_statusdata_field']);


			update_post_meta( $post_id, '_cpt_books_statusdata_key', $my_data );

	}




	//set COLUMNS for cpt_auftrag

	function cpt_set_auftrag_columns($newColumns){
		$newColumns = array();
		$newColumns['cb'] = 'Select';
		$newColumns['title'] = 'Buch';
		$newColumns['fullname'] = 'Name';
		$newColumns['email'] = 'E-Mail';
		$newColumns['einrichtung'] = 'Einrichtung';
		$newColumns['message'] = 'Nachricht';
		$newColumns['zeitraum'] = 'Zeitraum';
		$newColumns['status'] = 'Ausgeliehen';
		$newColumns['date'] = 'Aufgegeben';
		return $newColumns;

	}

	function cpt_custom_auftrag_columns($column, $post_id){
		
		switch ($column){

			
			case 'fullname' ;
				$fullname = get_post_meta($post_id,'_cpt_auftrag_fullnamedata_key', true);
				echo $fullname;
			break;
			
			case 'email' ;
				 $email = get_post_meta( $post_id,'_cpt_auftrag_emaildata_key', true);
				 echo $email;
			break;

			case 'einrichtung' ;
				$einrichtung = get_post_meta($post_id,'_cpt_auftrag_einrichtungdata_key', true);
				echo $einrichtung;
			break;

			case 'zeitraum' ;
				$zeitraum = get_post_meta($post_id,'_cpt_auftrag_zeitraumdata_key', true);
				echo $zeitraum;
			break;

			case 'status' ;
				$status = get_post_meta($post_id,'_cpt_auftrag_statusdata_key', true);
				?>		<input type="checkbox" <?php checked(esc_attr($status), true, true); ?> >    	<?php
			break;

			case 'message' : 
				echo get_the_excerpt();
			break;

		}
	}

	//META BOXES for cpt's

	// META BOX for cpt_auftrag  Nachname, Vorname

	function cpt_auftrag_fullname(){
		add_meta_box( 'auftrag_fullname', 'User Fullname', array($this, 'auftrag_fullname_callback'), 'cpt_auftrag', 'side');
	}

	function auftrag_fullname_callback($post){
		wp_nonce_field( 'cpt_save_auftrag_fullname_data', 'cpt_auftrag_fullnamedata_meta_box_nonce');
	
		$value = get_post_meta($post->ID, '_cpt_auftrag_fullnamedata_key', true);	

		echo '<label for="cpt_auftrag_fullnamedata_field"> User Fullname: </label>';
		echo '<input type="text" id="cpt_auftrag_fullnamedata_field" name="cpt_auftrag_fullnamedata_field" value="' . esc_attr($value) . '" size= "25" />';
	}

	function cpt_save_auftrag_fullname_data ($post_id){

		if( ! isset($_POST['cpt_auftrag_fullnamedata_meta_box_nonce'])){
			
			return;
		
			}

			if( ! wp_verify_nonce($_POST['cpt_auftrag_fullnamedata_meta_box_nonce'], 'cpt_save_auftrag_fullname_data')){
				
				return;
			}
			
			if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return;
			}

			if(! current_user_can ('edit_post', $post_id)){
				
				return;
			}

			if(! isset( $_POST['cpt_auftrag_fullnamedata_field'])){
				
				return;
			}
			
			$my_data = sanitize_text_field( $_POST['cpt_auftrag_fullnamedata_field'] );

			update_post_meta( $post_id, '_cpt_auftrag_fullnamedata_key', $my_data );

	}


	//META BOX cpt_auftrag - Abspeichern von Email-Adressen während der Auftragserstellung

	
	function cpt_auftrag_email(){
		add_meta_box( 'auftrag_email', 'User E-Mail', array($this, 'auftrag_email_callback'), 'cpt_auftrag', 'side');
	}

	function auftrag_email_callback($post){
		wp_nonce_field( 'cpt_save_auftrag_email_data', 'cpt_auftrag_emaildata_meta_box_nonce');
	
		$value = get_post_meta($post->ID, '_cpt_auftrag_emaildata_key', true);	

		echo '<label for="cpt_auftrag_emaildata_field"> User E-Mail Address: </label>';
		echo '<input type="email" id="cpt_auftrag_emaildata_field" name="cpt_auftrag_emaildata_field" value="' . esc_attr($value) . '" size= "25" />';
	}

	function cpt_save_auftrag_email_data ($post_id){

		if( ! isset($_POST['cpt_auftrag_emaildata_meta_box_nonce'])){
			
			return;
		
			}

			if( ! wp_verify_nonce($_POST['cpt_auftrag_emaildata_meta_box_nonce'], 'cpt_save_auftrag_email_data')){
				
				return;
			}
			
			if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return;
			}

			if(! current_user_can ('edit_post', $post_id)){
				
				return;
			}

			if(! isset( $_POST['cpt_auftrag_emaildata_field'])){
				
				return;
			}
			
			$my_data = sanitize_text_field( $_POST['cpt_auftrag_emaildata_field'] );

			update_post_meta( $post_id, '_cpt_auftrag_emaildata_key', $my_data );

	}
	

	//META BOX cpt_auftrag - Abspeichern von Email-Adressen während der Auftragserstellung

	function cpt_auftrag_einrichtung(){
		add_meta_box( 'auftrag_einrichtung', 'Einrichtung', array($this, 'auftrag_einrichtung_callback'), 'cpt_auftrag', 'side');
	}

	function auftrag_einrichtung_callback($post){
		wp_nonce_field( 'cpt_save_auftrag_einrichtung_data', 'cpt_auftrag_einrichtungdata_meta_box_nonce');
	
		$value = get_post_meta($post->ID, '_cpt_auftrag_einrichtungdata_key', true);	

		echo '<label for="cpt_auftrag_einrichtungdata_field"> Einrichtung: </label>';
		echo '<input type="text" id="cpt_auftrag_einrichtungdata_field" name="cpt_auftrag_einrichtungdata_field" value="' . esc_attr($value) . '" size= "25" />';
	}

	function cpt_save_auftrag_einrichtung_data ($post_id){

		if( ! isset($_POST['cpt_auftrag_einrichtungdata_meta_box_nonce'])){
			
			return;
		
			}

			if( ! wp_verify_nonce($_POST['cpt_auftrag_einrichtungdata_meta_box_nonce'], 'cpt_save_auftrag_einrichtung_data')){
				
				return;
			}
			
			if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return;
			}

			if(! current_user_can ('edit_post', $post_id)){
				
				return;
			}

			if(! isset( $_POST['cpt_auftrag_einrichtungdata_field'])){
				
				return;
			}
			
			$my_data = sanitize_text_field( $_POST['cpt_auftrag_einrichtungdata_field'] );

			update_post_meta( $post_id, '_cpt_auftrag_einrichtungdata_key', $my_data );

	}


	//META BOX cpt_auftrag - Transmit Zeitraum


	function cpt_auftrag_zeitraum(){
		add_meta_box( 'auftrag_zeitraum', 'Zeitraum', array($this, 'auftrag_zeitraum_callback'), 'cpt_auftrag', 'side');
	}

	function auftrag_zeitraum_callback($post){
		wp_nonce_field( 'cpt_save_auftrag_zeitraum_data', 'cpt_auftrag_zeitraumdata_meta_box_nonce');
	
		$value = get_post_meta($post->ID, '_cpt_auftrag_zeitraumdata_key', true);	

		echo '<label for="cpt_auftrag_zeitraumdata_field"> Zeitraum: </label>';
		echo	'<script>';
		echo		'$( function() {';
		echo			'$( "#cpt_auftrag_zeitraumdatepicker_field" ).datepicker();';
		echo		'} );';
		echo	'</script>';
		echo '<input type="text" id="cpt_auftrag_zeitraumdatepicker_field" name="cpt_auftrag_zeitraumdatepicker_field" value="' . esc_attr($value) . '" size= "25" />';
	}

	function cpt_save_auftrag_zeitraum_data ($post_id){

		if( ! isset($_POST['cpt_auftrag_zeitraumdata_meta_box_nonce'])){
			
			return;
		
			}

			if( ! wp_verify_nonce($_POST['cpt_auftrag_zeitraumdata_meta_box_nonce'], 'cpt_save_auftrag_zeitraum_data')){
				
				return;
			}
			
			if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return;
			}

			if(! current_user_can ('edit_post', $post_id)){
				
				return;
			}

			if(! isset( $_POST['cpt_auftrag_zeitraumdatepicker_field'])){
				
				return;
			}
			
			$my_data = sanitize_text_field( $_POST['cpt_auftrag_zeitraumdatepicker_field'] );

			update_post_meta( $post_id, '_cpt_auftrag_zeitraumdata_key', $my_data );

	}


	//META BOX cpt_auftrag - Transmit Zeitraum


	function cpt_auftrag_status(){
		add_meta_box( 'auftrag_status', 'Status', array($this, 'auftrag_status_callback'), 'cpt_auftrag', 'side');
	}

	function auftrag_status_callback($post){
		wp_nonce_field( 'cpt_save_auftrag_status_data', 'cpt_auftrag_statusdata_meta_box_nonce');
	
		$value = get_post_meta($post->ID, '_cpt_auftrag_statusdata_key', true);	
		?>
		<label for="cpt_auftrag_statusdata_field">Ausgeliehen</label>
		<input type="checkbox" id="cpt_auftrag_statusdata_field" name="cpt_auftrag_statusdata_field" <?php if( $value == true ) { ?>checked="checked"<?php } ?> />
		<?php
	}

	function cpt_save_auftrag_status_data ($post_id){

		if( ! isset($_POST['cpt_auftrag_statusdata_meta_box_nonce'])){
			return;
			echo "POST ERROR";
			}

			if( ! wp_verify_nonce($_POST['cpt_auftrag_statusdata_meta_box_nonce'], 'cpt_save_auftrag_status_data')){
				echo "POST1ERROR";
				return;
			}
			
			if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				echo "POST2 ERROR";
				return;
			}

			if(! current_user_can ('edit_post', $post_id)){
				echo "POST3 ERROR";
				return;
			}

			$my_data = isset( $_POST['cpt_auftrag_statusdata_field']);

			update_post_meta( $post_id, '_cpt_auftrag_statusdata_key', $my_data );

	}


	//colorize admin panel
	
	function cpt_auftrag_classes($classes) {
		global $post;
			$customMetaVariable = get_post_meta( $post->ID, '_cpt_auftrag_statusdata_key', true );
		if($customMetaVariable == '1'){
			$classes[] = 'cssClassName';
			return $classes;
		}
	}


}

		 


