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
		wp_enqueue_script( 'jquery-js', plugin_dir_url( __FILE__ ) . 'js/jquery.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-js', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cptlibrary-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'cptlibrary-ajax', plugin_dir_url( __FILE__ ) . 'js/cptlibrary-ajax.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'cptlibrary-ajax', 'wp_ajax' , array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
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



		//shortcode zur katalog teaser ansicht mit figcaption im grid

		function cpt_short1() {
			$print = '';
			$items = get_posts( array(
				'post_type'      => 'cpt_books',
				'post_status'    => 'publish',
				'meta_key'   => '_cpt_books_statusdata_key',
				'order' 	 => 'ASC',
				'posts_per_page' => -1
				) );

			$print .='<div class="js-filter2">';
			$print .='<div class="container-fluid">';

			$print .='<div class="card-deck">';
			$print .='<div class="row">';
			if ( $items) {
				   foreach ( $items as $item ) {
					$item_name =  wp_trim_words( get_the_title($item->ID), 3, '...' );
					$print .='<div class="col-xl-4 col-md-4 col-sm-4">';
					$print .='<div class="card mx-auto mb-5">';
					$print .='<img class="card-img-top">'.get_the_post_thumbnail($item->ID,'large').'';
					$print .='<div class="card-body">';
					$print .='<h5 class="card-title">'.$item_name.'</h5>';
					$print .='<p class="card-text">'.wp_trim_words( get_the_excerpt( $item->ID), 3, '...' ).'</p>';
					$print .='</div>';
					$print .='<div class="card-body">';
					if(get_post_meta($item->ID,'_cpt_books_statusdata_key', true) == false){
					$print .='<a href="'.get_permalink($item->ID).'" class="btn btn-danger btn-sm">Zum Buch</a>';
					} else{
						$print .='<a href="'.get_permalink($item->ID).'" class="btn btn-secondary btn-sm">Entliehen</a>';
					}
					$print .='</div>';
					$print .='</div>';
					$print .='</div>';
				}
			} 
			
			
			$print .= '</div>';
			$print .= '</div>';
			$print .= '</div>';
			$print .= '</div>';
		

			return $print;
		}

		
		
			// shortcode filter categories with ajax call
		function cpt_short_categories() {
			ob_start();
			?>
				<form class="js-filter" action="" method="POST">
					<?php
										
							if( $terms = get_categories( array(
								'orderby' => 'name',
								'order'   => 'ASC'
							) ) ) : 
							
								// if categories exist, display the dropdown
								echo '<select name="categoryfilter"><option value="">Auswählen</option>';
								foreach ( $terms as $term ) :
									echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as an option value
								endforeach;
								echo '</select>';
							endif;
					?>
					
					<button class="js-filter-item">Filter anwenden</button>
					<input type="hidden" name="action" value="myfilter">
					<a href="<?php home_url();?>"></a><button class="btn">Alle Artikel</button></a>
				</form>
			
			<div class="js-response"></div>

			

			<?PHP

			return ob_get_clean();

		}

		//ajax callback filter function for inserting category content into js-filter class

		function cpt_filter_function(){

			$args = array(
				'post_type'      => 'cpt_books',
				'post_status'    => 'publish',
				'posts_per_page' => -1
 			);
		 
		 
			// for taxonomies / categories
			if( isset( $_POST['categoryfilter'] ) )
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field' => 'id',
						'terms' => $_POST['categoryfilter']
					)
				);
		 
			$query = new WP_Query( $args );
			echo '<div class="grid-main">';
			echo '<div class="container-fluid">';
			echo '<div class="card-deck">';
			echo '<div class="row">';
			if( $query->have_posts() ) :
				while( $query->have_posts() ): $query->the_post();
					$post_name =  wp_trim_words( get_the_title($query->post->post_title), 3, '...' );
					echo '<div class="col-xl-4 col-md-4 col-sm-4">';
					echo '<div class="card mx-auto mb-5">';
					echo '<img class="card-img-top">'.get_the_post_thumbnail($query->post->ID, 'large').' </img>';
					echo '<div class="card-body">';
					echo '<h5 class="card-title">'.$post_name.'</h5>';
					echo '<p class="card-text">'.wp_trim_words( get_the_excerpt(  $query->post->ID), 5, '...' ).'</p>';
					echo '</div>';
					echo '<div class="card-body">';
					if(get_post_meta( $query->post->ID,'_cpt_books_statusdata_key', true) == false){
					echo '<a href="'.get_permalink( $query->post->ID).'" class="btn btn-danger btn-sm">Zum Buch</a>';
					} else{
						echo '<a href="'.get_permalink( $query->post->ID).'" class="btn btn-secondarybtn-sm">Entliehen</a>';
					}
					echo '';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				endwhile;
				wp_reset_postdata();
			else :
				echo 'No posts found';
			endif;
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		 
			die();

		}	



		


}