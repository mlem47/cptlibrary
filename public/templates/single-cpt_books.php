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
		   <?php the_post_thumbnail('medium')?>
		   </div>
               <div class="col">
					<div class="card flex-md-row mb-4 box-shadow h-md-250">
							<div class="card-body d-flex flex-column align-items-start">
								<h2 class="mb-0">
								<a class="text-dark" href="<?php the_permalink() ?>"><?php the_title() ?></a>
								</h2>
							</div>
						</div>    
					<div class="card flex-md-row mb-4 box-shadow h-md-250">
						<div class="card-body d-flex flex-column align-items-start">
							<strong class="d-inline-block mb-2 text-primary">Beschreibung</strong>
							<p class="card-text mb-auto"><?php the_excerpt() ?></p>
						</div>        
					</div>
               </div>
            </div><!-- column -->		
   
	<?php endwhile; endif; ?>

			
	<?php 
		$check_status = get_post_meta($id,'_cpt_books_statusdata_key', true);
		if($check_status == (int)0){
	
	?>

			<div class="row mb-2"></div>
				<div class="col">
				<div>
					<h3>Sie möchten dieses Buch ausleihen?</h3>
					<p>
						Tragen Sie ihren Namen ein, optional ihre E-Mail Adresse und wählen Sie dann ihre Betriebsstätte aus.
						Im Anschluss klicken Sie auf den Button ausleihen.
						Das Buch wird Ihnen durch die Hauspost zugestellt.
					</p>
					<br>
					<i>mit * markierte Felder sind Pflichtfelder.</i>
				</div>
				
				<br>
					<form id="post_entry" name="post_entry" method="post" action="">
						<div class="form-row">
							<input class="form-control" type="hidden" id="post_title" name="post_title" value="<?php the_title() ?>"/>
							<div class ="form-group col-md-6">
									<label>Vorname*:</label><br />
									<input class="form-control" type="text" id="post_vorname" name="post_vorname" required="required" />
							</div>
							<div class ="form-group col-md-6">
								<label for="einrichtungSelect">Einrichtung*:</label><br>
								<select class="form-control" id="einrichtungSelect" name="einrichtungSelect">
								<option selected="selected">Einrichtung wählen</option>

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
						</div>
						<div class="form-row">
							<div class ="form-group col-md-6">
								<label>Nachname*:</label><br />
								<input class="form-control" type="text" id="post_nachname" name="post_nachname" required="required" />
							</div>
							
							<div class ="form-group col-md-6">
								<label for="post_datepicker"> Zeitraum*: <i> Der Artikel wird für 28 Tage angefordert. </i> </label><br>
										<script>
										$(function() {
												$( "#post_datepicker" ).datepicker({
													dateFormat: "y-m-d",
													changeMonth: true,
													changeYear: true,
													minDate: "dateToday",
													onClose: function() {
													var date2 = $('#post_datepicker').datepicker('getDate');
													date2.setDate(date2.getDate()+28)
													$( "#post_enddatepicker" ).datepicker("setDate", date2);
												}
												});
											});
											
										</script>
								<input class="form-control" type="text" id="post_datepicker" name="post_datepicker" required="required" size= "25" />	
							</div>
							
						</div>
						<div class="form-row">
							<div class ="form-group col-md-6">
								<label>E-Mail*:</label><br />
								<input class="form-control" type="email" id="post_email" name="post_email" required="required" />
							</div>				
							<div class ="form-group col-md-6">
								<!-- <label for="post_enddatepicker">Fristende:</label><br /> -->
									<script>
										$(document).ready(function(){
										$( "#post_enddatepicker" ).datepicker(
											{
											dateFormat: "y-m-d",
											changeMonth: true,
											changeYear: true,
											});
										});
									</script>
								<input class="form-control" readonly  type="hidden" id="post_enddatepicker"  name="post_enddatepicker" size= "25" />
							
							</div>
							<div class ="form-group col-md-6">
								<label>Nachricht: <i>optional</i></label><br />
								<textarea maxlength="50" class="form-control"  id="post_desc" name="post_desc"></textarea>
							</div>
						</div>
						
						<div class="row mb-2">
							<div class ="form-group col-md-6">
									<input class="button" id="submit_post" type="submit" name="post_submit" value="Submit">	
							</div>
						</div>
					</form>
					
					
				</div>
			</div>

		
	<?php
			}
			else{
				echo '<strong>Dieses Buch ist nicht verfügbar</strong>';
			}
	?>



		<!-- Modal -->
	<div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Ausleihbestätigung</h5>
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Der Artikel wurde für Sie reserviert.
				</div>
				<div class="modal-footer center">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>	

</div>
<?php 

	//submit arguments into generating new cpt post cpt_auftrag
	$id = get_the_ID($post);
	$meta_value = get_post_meta($id,'_cpt_books_statusdata_key', true);
	$meta_thumbnail = get_post_meta($id,'_thumbnail_id', true);

	if ($_POST['post_submit'] == 'Submit' && $meta_value == (int)0) {

		$new_auftrag = wp_insert_post( array (
			'post_title' 		=> $_POST['post_title'],
			'post_content' 		=> $_POST['post_desc'],
			// some simple key / value array
			'meta_input' => array(

				'_cpt_auftrag_fullnamedata_key'		=> $_POST['post_vorname'] . ' ' . $_POST['post_nachname'],
				'_cpt_auftrag_emaildata_key'		=> $_POST['post_email'],
				'_cpt_auftrag_einrichtungdata_key' 	=> $_POST['einrichtungSelect'],
				'_cpt_auftrag_zeitraumdata_key'		=> $_POST['post_datepicker'],
				'_cpt_auftrag_zeitraumenddata_key'	=> $_POST['post_enddatepicker'],
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
		$meta_enddate = get_post_meta($new_auftrag,'post_enddatepicker', true);
	

		?>

	
		<script>
			
		// $('#checkout').modal('show');

		$(document).ready(function(){
		$("#checkout").modal('show');
		let url = "<?php echo $new_url;?>"
		$("#checkout").on('hidden.bs.modal', function () {
			window.location = url
		});
		});

		</script>

		<?php

	} else {
			return;
		}



 get_footer(); 