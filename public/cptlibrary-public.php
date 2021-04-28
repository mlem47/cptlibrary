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

			$print .='<div class="js-filter2">';
			$print .='<div class="container-fluid">';
			if ( $items) {
				   foreach ( $items as $item ) {
					$item_name =  $item->post_title;
					$print .='<div class="grid-container">';
					$print .='<div class="Thumbnail"><img scr='.get_the_post_thumbnail($item->ID,'thumbnail').'</img></div>';
					$print .='<div class="Title">'.$item_name.'</div>';
					$print .='<div class="Excerpt">'.wp_trim_words( get_the_excerpt( $item->ID), 20, '' ).'</div>';
					$print .='<div class="Read-more"><button class="btn-readmore"><a href="'.get_permalink($item->ID).'">Zum Buch</a></button></div>';
					$print .='</div>';
				}
			} 
			
		 	
			if ( $itemsbooked) {
				   foreach ( $itemsbooked as $item ) {
					$item_name =  $item->post_title;

					$print .='<div class="grid-container">';
					$print .='<div class="Thumbnail"><img scr='.get_the_post_thumbnail($item->ID,'thumbnail').'</img></div>';
					$print .='<div class="Title">'.$item_name.'</div>';
					$print .='<div class="Excerpt">'.wp_trim_words( get_the_excerpt( $item->ID), 20, '' ).'</div>';
					$print .='<div class="Read-more"><button class="btn-readmore-booked"><a href="'.get_permalink($item->ID).'">Entliehen</a></button></div>';
					$print .= '</div>';
				}
			} 
			$print .= '</div>';
			$print .='<div>';
			

			return $print;
			}

		
		
			// shortcode filter categories with ajax call
		function cpt_short_categories() {
			ob_start();
			?>
				<form class="js-filter" action="" method="POST">
					<?php
							$allItems = get_posts(array(
								'post_type'      => 'cpt_books',
								'post_status'    => 'publish',
								'posts_per_page' => -1,
							));
							
							if( $terms = get_categories( array(
								'orderby' => 'name',
								'order'   => 'ASC'
							) ) ) : 
							
								// if categories exist, display the dropdown
								echo '<select name="categoryfilter"><option value="">Kategorie auswählen</option>';
								
								foreach ( $terms as $term ) :
									echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as an option value
								endforeach;
								echo '</select>';
							endif;
					?>
					
					<button class="js-filter-item">Filter anwenden</button>
					<input type="hidden" name="action" value="myfilter">
				</form>
			
			<div class="js-response"></div>

			

			<?PHP

			return ob_get_clean();

			}


	


		// shortcode  with ajax call to filter posts for each category
    
		function cpt_short_cat_ajax(){
		
		?>
		<div class="js-filter">
			<form action="" method="POST">
					<?php
							if( $terms = get_categories( array(
								'orderby' => 'name',
								'order'   => 'ASC'
							) ) ) : 
							
								// if categories exist, display the dropdown
								echo '<select name="categoryfilter"><option value="">Kategorie auswählen</option>';
								foreach ( $terms as $term ) :
									echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as an option value
								endforeach;
								echo '</select>';
							endif;
					?>
					
					<button class="js-filter-item">Filter anwenden</button>
					<input type="hidden" name="action" value="myfilter">
				</form>
			
			

			<?

			// the meta_key 'color' with the meta_value 'white'
			$args = array(
				'post_type'      => 'cpt_books',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			);
			
			
			$query = new WP_Query( $args );

				echo '<div class="container-fluid"';
					if( $query->have_posts() ) :
						while( $query->have_posts() ): $query->the_post();
							$post_name =  $query->post->post_title;
							echo '<div class="grid-container">';
							echo '<div class="Thumbnail"><img scr='.get_the_post_thumbnail($query->post->ID,'thumbnail').'</img></div>';
							echo '<div class="Title">'.$post_name.'</div>';
							echo '<div class="Excerpt">'.wp_trim_words( get_the_excerpt( $query->post->ID), 20, '' ).'</div>';
							echo '<div class="Read-more"><button class="btn-readmore-booked"><a href="'.get_permalink($query->post->ID).'">Entliehen</a></button></div>';
							echo '</div>';
						endwhile;
						wp_reset_postdata();
					else :
						echo 'No posts found';
					endif;
		?>
				</div>
			</div>
		<div class="js-response"></div>

		<?

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
		 
			if( $query->have_posts() ) :
				while( $query->have_posts() ): $query->the_post();
					$post_name =  $query->post->post_title;

					echo '<div class="grid-container">';
					echo '<div class="Thumbnail"><img scr='.get_the_post_thumbnail($query->post->ID,'thumbnail').'</img></div>';
					echo '<div class="Title">'.$post_name.'</div>';
					echo '<div class="Excerpt">'.wp_trim_words( get_the_excerpt( $query->post->ID), 20, '' ).'</div>';
					echo '<div class="Read-more"><button class="btn-readmore-booked"><a href="'.get_permalink($query->post->ID).'">Entliehen</a></button></div>';
					echo '</div>';
				endwhile;
				wp_reset_postdata();
			else :
				echo 'No posts found';
			endif;
		 
			die();

		}	



}
