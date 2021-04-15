<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cptlibrary-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cptlibrary-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-js', plugin_dir_url( __FILE__ ) . 'js/jquery.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-js', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}


		//shortcode zur katalog teaser ansicht mit figcaption im grid

		function cpt_short1( $atts ) {
			$print = '';
			$items = get_posts( array(
				'post_type'      => 'cpt_books',
				'post_status'    => 'publish',
				'meta_key'   => '_cpt_books_statusdata_key',
    			'meta_value' => false,
				'order' 	 => 'ASC',
				'posts_per_page' => -1
				) );

			$itemsbooked = get_posts( array(
				'post_type'      => 'cpt_books',
				'post_status'    => 'publish',
				'meta_key'   => '_cpt_books_statusdata_key',
    			'meta_value' => true,
				'order' 	 => 'ASC',
				'posts_per_page' => -1
				) );

			$print .='<div class="gridcontainer">';
			
			if ( $items) {
				   foreach ( $items as $item ) {
					$item_name =  $item->post_title;
					$print .='<figure><a href="'.get_permalink($item->ID).'">';
					$print .= '<img class="katalog-teaser"'.get_the_post_thumbnail($item->ID,'thumbnail');
					$print .= '<figcaption class="teaser-caption-text">'.$item_name.'</figcaption></figure>';
				}
			} 

			if ( $itemsbooked) {
				   foreach ( $itemsbooked as $item ) {
					$item_name =  $item->post_title;
					$print .='<figure><a href="'.get_permalink($item->ID).'">';
					$print .= '<img class="katalog-teaser-booked"'.get_the_post_thumbnail($item->ID,'thumbnail');
					$print .= '<figcaption class="teaser-caption-text">'.$item_name.'</figcaption></figure>';
				}
			} 
			$print .= '</div>';


			return $print;
			}
	
	
		//hook into single_template to load our custom_post_type template
	
		function load_cpt_books( $template ) {
	
			if ( 'cpt_books' === get_post_type() )
			return dirname( __FILE__ ) . '/templates/single-cpt_books.php';
	
			return $template;
		}

		function load_cpt_auftrag_checkout( $template ) {
	
			if ( 'cpt_auftrag' === get_post_type() )
			return dirname( __FILE__ ) . '/templates/single-cpt_auftrag.php';
	
			return $template;
		}
		
}
