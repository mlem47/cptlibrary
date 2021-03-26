<?php get_header();?>


<form id="post_entry" name="post_entry" method="post" action="">
    <p>
        <label>Auftragstitel</label><br />
        <input type="text" id="post_title" name="post_title" value="<?php the_title() ?>"/>
	</p>
	
    <p>
        <label>Name & E-Mail</label><br />
		<input type="text" id="post_desc" name="post_desc" />
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
        <label>Einrichtung</label><br />
        <input type="text" id="post_artist" name="post_artist" />
        <input type="hidden" name="post_type" id="post_type" value="cpt_auftrag" />
        <input type="hidden" id="post_action" name="post_action" value="post" />
    </p>
    <p>
        <input type="submit" name="post_submit" value="Submit" />
    </p>
    <?php wp_nonce_field( 'new_song_nonce' ); ?>
</form>

<?php 

///if User !priviliged wp_insert_post possibly won't

if($_POST['post_submit'] == 'Submit') {
    $new_auftrag = array(
        'post_title' 		=> $_POST['post_title'],
		'post_content' 		=> $_POST['post_desc'],
		'tax_input' 		=> $taxonomy,
        'post_type' 		=> 'cpt_auftrag',
        'post_status' 		=> 'publish',
        'comment_status' 	=> 'closed',
        'ping_status' 		=> 'closed'
	);
	
	$taxonomy = array(
		'einrichtung' => array(
			$_POST['einrichtungSelect'],
		),
	);

//// INSERT TERM ////https://tecserve.eu/wordpress/tax_input-in-wp_insert_post-richtig-verwenden/ /////

	$department = 'Food';
	$section = 'Produce';
	// Check if department exists
	$department_term = term_exists( $department, 'category', 0 );
	// Create if not
	if ( !$department_term ) {
		$department_term = wp_insert_term( $department, 'category', array( 'parent' => 0) );
	}
	// Check if section exists as child of department
	$section_term = term_exists( $section, 'category', $department_term['term_taxonomy_id'] );
	// Create if not
	if ( !$section_term ) {
		$section_term = wp_insert_term( $section, 'category', array( 'parent' => $department_term['term_taxonomy_id'] ) );
	}
	$taxonomy = array(
		'category' => array(
			$section_term['term_taxonomy_id'],
			$department_term['term_taxonomy_id']
		)
	);
	$post = array(
		'post_title' => 'Hallo neuer Beitrag!',
		'post_content' => 'Hier steht ganz viel Inhalt',
		'tax_input' => $taxonomy
	);
	$post_id = wp_insert_post( $post );

    $post_id = wp_insert_post($new_auftrag);
    add_post_meta($post_id, "_song_artist", $_POST['post_artist']);
}
?>











	<div class="row">
		<div class="col">
			<form>
				<div class="form-group">
					<label for="exampleFormControlInput1">Email address</label>
					<input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
				</div>
				<div class="form-group">
					<label for="buchid">Buch</label>
					<input type="text" class="form-control" id="buchid" placeholder="<?php the_title() ?>">
				</div>
				
				<div class="form-group">
					<label for="einrichtungSelect">Einrichtung</label>
					<select class="form-control" id="einrichtungSelect">
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
				
				<div class="form-group">
					<script>
						jQuery(document).ready(function($) {
							$("#startdatepicker").datepicker();
							
						});
					</script>
					<p>Anfangsdatum:<div id="startdatepicker"></div></p> 
				</div>
			</form>

			<?php
			// Create post object
			
			$new_auftrag = array(
			'post_title'    => wp_strip_all_tags( $_POST['$title'] ),
			'post_status'   => 'publish',
			'post_date'		=> '',
			'post_author'   => 1,
			'post_type'		=> 'cpt_auftrag',
			'tax_input' 	=> 'Kennziffer'
			);
			
			// Insert the post into the database
			$post_id = wp_insert_post( $new_auftrag );

			if($post_id){
				echo "Post successfully published!";
			} else {
				echo "Something went wrong, try again.";
			}

			?>


		</div> <!-- col end -->
	</div> <!-- row2 end -->

	

  
</div> <!-- end of container-singlecptvooks -_>
   
<?php get_footer(); ?>



