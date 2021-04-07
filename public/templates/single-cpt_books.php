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
</form>

<?php 




	if($_POST['post_submit'] == 'Submit') {

		$new_auftrag = wp_insert_post( array (
			'post_title' 		=> $_POST['post_title'],
			'post_content' 		=> $_POST['post_desc'],
			 // some simple key / value array
			 'meta_input' => array(
				'_cpt_auftrag_emaildata_key' => $_POST['post_email'],
				'_cpt_auftrag_einrichtungdata_key' => $_POST['einrichtungSelect']
				),
			'post_type' 		=> 'cpt_auftrag',
			'post_status' 		=> 'publish',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed',
		));

		
	};	


	?>

<?php get_footer(); ?>