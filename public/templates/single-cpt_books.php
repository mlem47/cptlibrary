<?php get_header(); ?>

 <div class="container-singlecptbooks">
       
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
	<div class="row">
		<div class="col">
			<form>
			<div class="form-group">
				<label for="exampleFormControlInput1">Email address</label>
				<input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
			</div>
			<div class="form-group">
				<label for="einrichtungSelect">Einrichtung</label>
				<select class="form-control" id="einrichtungSelect">
				<option selected="selected">Einrichtung auswählen</option>

				<?php 
				$items = get_posts( array(
					'post_type'      => 'cpt_einrichtung',
					'post_status'    => 'publish',
					'order' 	 => 'ASC',
					'posts_per_page' => -1
					) );
				if ( $items) {
						   foreach ( $items as $item ) {
							$item_name =  $item->post_title;
							echo '<option >'.$item_name.'</option>';
						}
				}

				?>
				</select>
			</div>
			</form>
		</div> <!-- col end -->
	</div> <!-- row2 end -->

  
</div> <!-- end of container-singlecptvooks -_>
   
<?php get_footer(); ?>