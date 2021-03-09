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
		/* Template Name: Song Entry Form */
		get_header();

		if($_POST['post_submit'] == 'Submit') {
			$args = array(
				'post_title' => $_POST['post_title'],
				'post_id' => $_POST['post_desc'],
				'post_type' => 'cpt_auftrag', //muss hier der urpsrungspost oder der post in den geschrieben wird stehen?
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed'
			);

			$pid = wp_insert_post($args);
			add_post_meta($pid, "_song_artist", $_POST['post_artist']);
		}

		?>

		<form id="post_entry" name="post_entry" method="post" action="<?php echo get_page_link('354') ?>">
			<p>
				<label>Title</label><br />
				<input type="text" id="post_title" name="post_title" />
			</p>
			<p>
				<label>Description</label><br />
				<input type="text" id="post_desc" name="post_desc" />
			</p>
			<p>
				<label>Artist</label><br />
				<input type="text" id="post_artist" name="post_artist" />
				<input type="hidden" name="post_type" id="post_type" value="fav_songs" />
				<input type="hidden" id="post_action" name="post_action" value="post" />
			</p>
			<p>
				<input type="submit" name="post_submit" value="Submit" />
			</p>
			<?php wp_nonce_field( 'new_song_nonce' ); ?>
		</form>

	

   
<?php get_footer(); ?>