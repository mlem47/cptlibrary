<?php
/**
 * Template Name: Search Page
 */

?>
<?php get_header(); ?>

<div class="search-container">
    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <div class="search-page-form" id="ss-search-page-form"><?php get_search_form(); ?></div>
<?php
        echo '<div class="grid-main">';
			echo '<div class="container-fluid">';
			echo '<div class="row">';
			if( have_posts() ) :
                    while ( have_posts() ) : the_post();
					$post_name =  wp_trim_words( the_title(), 3, '...' );
					echo '<div class="col-xl-4 col-md-6 col-sm-4">';
					echo '<div class="card mx-auto mb-5">';
					echo '<img class="card-img-top">'.the_post_thumbnail('large').' </img>';
					echo '<div class="card-body">';
					echo '<h5 class="card-title">'.$post_name.'</h5>';
					echo '<p class="card-text">'.wp_trim_words( the_excerpt(), 13, '...' ).'</p>';
					echo '</div>';
					echo '<div class="card-body">';
					echo '';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				endwhile;
			else :
				echo 'No posts found';
			endif;
			echo '</div>';
			echo '</div>';
			echo '</div>';
		 
            die();
            
?>

        </main><!-- #main -->
    </section><!-- #primary -->
</div>
<?php get_footer(); 