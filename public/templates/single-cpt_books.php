<?php
/*
 * Template Name: New Template
 * Template Post Type: cpt_books
 */
  
 get_header();  ?>



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
                            <p class="card-text mb-auto"><?php the_excerpt() ?></p>
                        </div>
                   </div>
               </div>
            </div><!-- column -->		
   
	<?php endwhile; endif; ?>


		
	<? 
	$check_status = get_post_meta($id,'_cpt_books_statusdata_key', true);
	if($check_status == (int)0){
	

	?>
		<div class="col">
			<form id="post_entry" name="post_entry" method="post" action="">
				<div class ="form-group">
					<p>
						<input class="form-control" type="hidden" id="post_title" name="post_title" value="<?php the_title() ?>"/>
					</p>

					<p>
						<label>Vorname</label><br />
						<input class="form-control" type="text" id="post_vorname" name="post_vorname" required="required" />
					</p>
					<p>
						<label>Nachname</label><br />
						<input class="form-control" type="text" id="post_nachname" name="post_nachname" required="required" />
					</p>

					<p>
						<label>E-Mail</label><br />
						<input class="form-control" type="email" id="post_email" name="post_email" required="required" />
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
									$( "#post_datepicker" ).datepicker({
										dateFormat: "dd/mm/yy",
										changeMonth: true,
										changeYear: true,
										minDate: "dateToday"
									});
								} );
							</script>
						<input class="form-control" type="text" id="post_datepicker" name="post_datepicker" required="required" size= "25" />
					</p>

					<p>

					<input class="form-control" id="submit_post" type="submit" name="post_submit" value="Submit"/>
						
					</p>
					

				</div>
			</form>
		</div> <!-- column end -->
</div> <!-- container end -->

<?
	
} else{

	echo '<strong>Dieses Buch ist nicht verfügbar</strong>';
}

?>
<?php 

	//submit arguments into generating new cpt post cpt_auftrag
	$id = get_the_ID($post);
	$meta_value = get_post_meta($id,'_cpt_books_statusdata_key', true);
	$meta_thumbnail = get_post_meta($id,'_thumbnail_id', true);

	if($_POST['post_submit'] == 'Submit' && $meta_value == (int)1){
		
		?>
		<script>
		alert('Das Buch is bereits reserviert');
		</script>
		<?

	} elseif ($_POST['post_submit'] == 'Submit' && $meta_value == (int)0) {

			$new_auftrag = wp_insert_post( array (
				'post_title' 		=> $_POST['post_title'],
				'post_content' 		=> $_POST['post_desc'],
				 // some simple key / value array
				 'meta_input' => array(
	
					'_cpt_auftrag_fullnamedata_key'		=> $_POST['post_vorname'] . ' ' . $_POST['post_nachname'],
					'_cpt_auftrag_emaildata_key'		=> $_POST['post_email'],
					'_cpt_auftrag_einrichtungdata_key' 	=> $_POST['einrichtungSelect'],
					'_cpt_auftrag_zeitraumdata_key'		=> $_POST['post_datepicker'],
					'_cpt_auftrag_booksiddata_key'		=> $id,
					'_thumbnail_id'						=> $meta_thumbnail,
					'_cpt_auftrag_statusdata_key'		=> true
					
					),

				'post_type' 		=> 'cpt_auftrag',
				'post_status' 		=> 'publish',
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed'

				
			));
		
			$update_books_status = update_post_meta( $id, '_cpt_books_statusdata_key', true );
			$new_url = get_the_permalink($new_auftrag);

			?>
			
			<script>
			window.open('<? echo $new_url ?>', 301);
			</script>

			<?

		}

		else {

			return;

		}

		
	?>

<?php get_footer();?>