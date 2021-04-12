<?php get_header();?>



<div class="container boxpadding">
       
       <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
   
   
           <div class="row mb-2">
               <div class="col">
                   <div class="card flex-md-row mb-4 box-shadow h-md-250">
                         <div class="card-body d-flex flex-column align-items-start">
                            <h2 class="mb-0">
                            <a class="text-dark" href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h2>
                        </div>
                    </div>            
               </div>
               <?php the_post_thumbnail("medium")?>
               
               <div class="col">
                   <div class="card flex-md-row mb-4 box-shadow h-md-250">
                        <div class="card-body d-flex flex-column align-items-start">
                            <strong class="d-inline-block mb-2 text-primary">Beschreibung</strong>
                            <p class="card-text mb-auto"><?php the_content() ?></p>
                        </div>
                   </div>
               </div>
            </div><!-- column -->		
   
	<?php endwhile; endif; ?>


		

		<div class="col">
			<form id="post_entry" name="post_entry" method="post" action="">
				<div class ="form-group">
					<p>
						<input class="form-control" type="hidden" id="post_title" name="post_title" value="<?php the_title() ?>"/>
					</p>

					<p>
						<label>Vorname</label><br />
						<input class="form-control" type="text" id="post_vorname" name="post_vorname" />
					</p>
					<p>
						<label>Nachname</label><br />
						<input class="form-control" type="text" id="post_nachname" name="post_nachname" />
					</p>

					<p>
						<label>E-Mail</label><br />
						<input class="form-control" type="email" id="post_title" name="post_email" />
					</p>
				
					
					<p>
						<label>Nachricht</label><br />
						<input class="form-control" type="textarea" id="post_desc" name="post_desc" />
					</p>
					<p>
					<label for="einrichtungSelect">Einrichtung</label><br>
					<select class="form-control" id="einrichtungSelect" name="einrichtungSelect">
						<option selected="selected"></option>

						<?php 
						$items = get_posts( array(
							'post_type'      => 'cpt_einrichtung',
							'post_status'    => 'publish',
							'order' 	 	 => 'ASC',
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
					</p>
					<p>
					<label for="post_datepicker"> Zeitraum: </label><br>
							<script>
								$( function() {
									$( "#post_datepicker" ).datepicker();
								} );
							</script>
						<input class="form-control" type="text" id="post_datepicker" name="post_datepicker" size= "25" />
					</p>

					<?
						
						if ( metadata_exists( 'post', $post_id, _cpt_books_statusdata_key ) ) {
							$meta_value = get_post_meta( $post_id, '_cpt_books_statusdata_key', true );

							if($meta_value == true){

							

							echo		'<p>';
							echo		'<input class="form-control" type="submit" name="post_submit" value="Submit" disabled/>';
							echo		'</p>';

							

							
							} else {

								echo		'<p>';
								echo		'<input class="form-control" type="submit" name="post_submit" value="Submit"/>';
								echo		'</p>';
							}

						}
					
					?>
				</div>
			</form>
		</div> <!-- column end -->
</div> <!-- container end -->

<?php 

	if($_POST['post_submit'] == 'Submit') {

		$new_auftrag = wp_insert_post( array (
			'post_title' 		=> $_POST['post_title'],
			'post_content' 		=> $_POST['post_desc'],
			 // some simple key / value array
			 'meta_input' => array(

				'_cpt_auftrag_fullnamedata_key'		=> $_POST['post_vorname'] . ' ' . $_POST['post_nachname'],
				'_cpt_auftrag_emaildata_key'		=> $_POST['post_email'],
				'_cpt_auftrag_einrichtungdata_key' 	=> $_POST['einrichtungSelect'],
				'_cpt_auftrag_zeitraumdata_key'		=> $_POST['post_datepicker'],
				'_cpt_auftrag_statusdata_key'		=> true
				),
			'post_type' 		=> 'cpt_auftrag',
			'post_status' 		=> 'publish',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'
		));
		
		$id = get_the_ID($post);		
		$update_books_status = update_post_meta( $id, '_cpt_books_statusdata_key', true );

		
	};	

	$submit_args = array(
		'meta_key' => '_cpt_books_statusdata_key',
		'meta_value' => true
	);
	 
	$submit_query = new WP_Query( $submit_args );

	?>

<?php get_footer(); ?>