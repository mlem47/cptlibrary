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


			return $print;
			}


		function cpt_short2() {
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


			return $print;
			}



		// shortcode to list all categories
		function cpt_short_categories() {
			$print = '';
			$categories = get_categories( array(
				'orderby' => 'name',
				'parent'  => 0
			) );
			 
			foreach ( $categories as $category ) {

					$print .='<div>'.$category->name.'</div>';
				
			}
			return $print;
			}

		// shortcode to list all categories
		function cpt_short_categories4() {

			?>
			
			<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
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
				
				<button>Filter anwenden</button>
				<input type="hidden" name="action" value="myfilter">
			</form>
			<div id="response"></div>

			

			<?PHP

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


		//Kategorie filter

		function misha_filter_function(){

			

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



		function cpt_short_cat_ajax(){

			?>	
				
				<div class="js-filter">
			<?php

				$args = array(
					'post_type'      => 'cpt_books',
					'post_status'    => 'publish',
					'posts_per_page' => -1
				);
			
			
				$query = new WP_Query( $args );
			
				if( $query->have_posts() ) :
					while( $query->have_posts() ): $query->the_post();
						$post_name =  $query->post->post_title;
						echo '<div class="container">';
						echo '<div class="grid-container">';
						echo '<div class="Thumbnail"><img scr='.get_the_post_thumbnail($query->post->ID,'thumbnail').'</img></div>';
						echo '<div class="Title">'.$post_name.'</div>';
						echo '<div class="Excerpt">'.wp_trim_words( get_the_excerpt( $query->post->ID), 20, '' ).'</div>';
						echo '<div class="Read-more"><button class="btn-readmore-booked"><a href="'.get_permalink($query->post->ID).'">Entliehen</a></button></div>';
						echo '</div>';
						echo '</div>';
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</>
		 
			<div class="categories">
			<ul>
				<li class="js-filter-item"><a href="">All</a></li>
				<?php
				$cat_args = array(
					'exclude' => array(1),
					'option_all' => 'All'
				);
			
				$categories = get_categories( $cat_args );

				foreach($categories as $cat): ?>
				<li class="js-filter-item"><a data-category="<?= $cat->term_id ;?>" href="<?= get_category_link($cat->term_id); ?>"><?= $cat->name; ?></a></li>
				<?php endforeach; ?>
			
			</ul>
			
			</div>

			<?php

		}


	/* 	function filter_ajax(){

			?>
				<div class="js-filter">
			<?php

				$args = array(
					'post_type'      => 'cpt_books',
					'post_status'    => 'publish',
					'posts_per_page' => -1
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
				endif;
				?>
			</div>
			

			
		 
			<div class="categories">
			<ul>
				<li class="js-filter-item"><a href="">All</a></li>
				<?php
				$cat_args = array(
					'exclude' => array(i),
					'option_all' => 'All'
				);
			
				$categories = get_categories( $cat_args );

				foreach($categories as $cat):
				 ?>
				<li class="js-filter-item"><a data-category="<?= $cat->term_id ;?>" href="<?= get_category_link($cat->term_id); ?>"><?= $cat->name; ?></a></li>
				<?php endforeach; ?>
			
			</ul>
			
			</div>

			<?php

		}
 */

		function filter_ajax(){

			$category = $_POST['category'];

			$args = array(
				'post-type' => 'cpt_books',
				'post_status'    => 'publish',
				'posts_per_page' => -1
			);

			if(isset($category)) {
				$args['category__in'] = array($category);
			}

			$query = new WP_Query($args);

			if($query->have_posts()) :
				while($query->have_posts()) : $query->the_post();
				the_title('<h2>', '</h2>');
				endwhile;
			endif;
			wp_reset_postdata();

			die();

		}


			
		// shortcode to test cron jobs
		function cpt_short_cron1() {
			$posts = get_posts( array(
				'post_type'      => 'cpt_auftrag',
				'post_status'    => 'publish',
				'meta_key'   => '_cpt_auftrag_zeitraumenddata_key',
				'order' 	 => 'ASC',
				'posts_per_page' => -1
				) );
			foreach ($posts as $post) {
					
					$today = date('y-n-d');
					$mydate = get_post_meta( $post->ID, '_cpt_auftrag_zeitraumenddata_key', true );
				
					echo   $today  . '<br>';
					echo   $mydate . '<br>' ;
				}

			}


		
}
