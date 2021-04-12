<?php get_header();?>



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
</div> <!-- container -->
           
   
   
   
<?php endwhile; endif; ?>


<form id="post_entry" name="post_entry" method="post" action="">
    <p>
        <label>Auftragstitel</label><br />
        <input type="text" id="post_title" name="post_title" value="<?php the_title() ?>"/>
	</p>

    <p>
        <label>E-Mail</label><br />
        <input type="email" id="post_title" name="post_email" />
	</p>
	
    <p>
        <label>Weitere Informationen</label><br />
		<input type="textarea" id="post_desc" name="post_desc" />
	</p>
	
    <p>
	<div class="form-group">
					<label for="einrichtungSelect">Einrichtung</label>
					<select class="form-control" id="einrichtungSelect" name="einrichtungSelect">
					<option selected="selected">Einrichtung auswählen</option>

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
		</div>
    </p>
    <p>
        <input type="submit" name="post_submit" value="Submit" />
    </p>
    <?php wp_nonce_field( 'new_song_nonce' ); ?>
</form>

<?php 




	if($_POST['post_submit'] == 'Submit') {
		$taxonomy = '';
		$Email = '';
		$Einrichtung = '';

		$new_auftrag = array(
			'post_title' 		=> $_POST['post_title'],
			'post_content' 		=> $_POST['post_desc'],
			'tax_input' 		=> $custom_tax,
			'post_type' 		=> 'cpt_auftrag',
			'post_status' 		=> 'publish',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed',
		);
		
		// $taxonomy = array(

		// 	'Email' 			=> $_POST['Email'],
		// 	'einrichtung' 		=> $_POST['Einrichtung'],
				
		// );

		///////////

	$Email = $_POST['Email'];
	$Einrichtung = $_POST['Einrichtung'];


	// Create Email if it doesn't exist
	if ( !$email_term ) {
		$email_term = wp_insert_term( $Email, 'tax_einrichtung', array( 'parent' => 0 ) );
	}


	// Create Einrichtung if it doesn't exist
	if ( !$einrichtung_term ) {
		$einrichtung_term = wp_insert_term( $Einrichtung, 'tax_einrichtung', array( 'parent' => $email_term['term_taxonomy_id'] ) );
	}

	$custom_tax = array(
		'tax_einrichtung' => array(
			$email_term['term_taxonomy_id'],
			$einrichtung_term['term_taxonomy_id']
		)
	);
	};	


	?>

<?php get_footer(); ?>
