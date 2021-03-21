<?php get_header(); ?>

 
       
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


		<div class="row mb-2">
			<div class="col">
				<div class="card flex-md-row mb-4 box-shadow h-md-250">
						<div class="card-body d-flex flex-column align-items-start">
						<h2 class="mb-0">
						<a class="text-dark" href="<?php the_permalink() ?>"><?php the_title() ?></a>
						</h2>
				</div>
			<?php the_post_thumbnail("medium")?>
			
			</div>
			</div><!-- column -->
			<div class="col">
				<div class="card flex-md-row mb-4 box-shadow h-md-250">
					<div class="card-body d-flex flex-column align-items-start">
					<strong class="d-inline-block mb-2 text-primary">Beschreibung</strong>
					<p class="card-text mb-auto"><?php the_content() ?></p>
				</div>
			</div>
			</div><!-- column -->			
		</div>
		



	<?php endwhile; endif; ?>

	<?php
		
				$print = '';
				$items = get_posts( array(
					'post_type'      => 'cpt_einrichtung',
					'post_status'    => 'publish',
					'order' 	 => 'ASC',
					'posts_per_page' => -1
					) );
				if ( $items) {
						$print .='<div class="gridcontainer">';
						   foreach ( $items as $item ) {
							$item_name =  $item->post_title;
							$print .='<figure><a href="'.get_permalink($item->ID).'">';
							$print .= '<img class="katalog-teaser"'.get_the_post_thumbnail($item->ID,'thumbnail');
							$print .= '<figcaption class="teaser-caption-text">'.$item_name.'</figcaption></figure>';
						}
						$print .= '</div>';
				}
				return $print;
				

	?>




		<form method=”post”>
		<p><label for=”cpt_auftrag_title”><?php the_title()?></label>

		<input type=”text” name=”cpt_auftrag_title” id=”cpt_auftrag_title” value="<?php the_title()?>" /></p>

		<p> <label for=”cpt_auftrag_ID”><?php the_ID(  )?></label>

		<input type="hidden" name=”cpt_auftrag_ID” id=”cpt_auftrag_ID”></input> </p>

		<button type=”submit”><?php _e('Submit') ?></button>


		<input type=”hidden” name=”post_type” id=”post_type” value=”cpt_auftrag” />


		<?php wp_nonce_field( 'cpt_nonce_action', 'cpt_nonce_field' ); ?>


		</form>

		<?php

			if (isset( $_POST['cpt_nonce_field'] )

			&& wp_verify_nonce( $_POST['cpt_nonce_field'], 'cpt_nonce_action' ) ) {

			// create post object with the form values

			$my_cptpost_args = array(

			'post_title'    => $_POST['cpt_auftrag_title'],

			'post_content'  => $_POST['cpt_auftrag_ID'],

			'post_status'   => 'pending',

			'post_type' => $_POST['cpt_auftrag']

			);
			// insert the post into the database

			$cpt_id = wp_insert_post( $my_cptpost_args, $wp_error);

}		?>

	

   
<?php get_footer(); ?>