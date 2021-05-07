<?php
/*
 * Template Name: New Template
 * Template Post Type: cpt_books
 */
  
 get_header();  ?>

	<div class="container boxpadding">

       
       <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
   
		<div class="row">
			<div class="col-md-4">
				<div class="card" style="width: 20rem;">
					<img class="card-img-top"> <?php the_post_thumbnail('large'); ?>
				</div>	
			</div>
			<div class="col-md-8">
					<h3 class="card-title"><?php the_title() ?></h3>
					<p><?php the_excerpt() ?></p>
			</div>
		</div>	
   
		<?php endwhile; endif; ?>

			
		<?php 
			$check_status = get_post_meta($id,'_cpt_books_statusdata_key', true);
			if($check_status == (int)0){
		
		?>

			<div class="row pt-5 pb-5 mb-2"></div>
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
								<select class="form-control" id="einrichtungSelect" name="einrichtungSelect" required="required">
								<option value="">Einrichtung wählen</option>

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
												$item_id = $item->ID;
												echo '<option value="'.$item_id.'" >'.$item_name.'</option>';
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
								<button class="btn-booked" id="submit_post" type="submit" name="post_submit" value="Submit">Bestellen</button>
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



		<!-- Modal for Submitting -->
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

				if(isset($_POST['einrichtungSelect'])){

					$meta_einrichtung_id = $_POST['einrichtungSelect'];
					$einrichtung_name  	 = get_the_title($meta_einrichtung_id);
					$einrichtung_mail  	 = get_post_meta($meta_einrichtung_id,'_cpt_einrichtung_emaildata_key', true);
				}
				
				if (isset($_POST['post_submit']) == 'Submit' && $meta_value == (int)0) {

					$new_auftrag = wp_insert_post( array (
						'post_title' 		=> $_POST['post_title'],
						'post_content' 		=> $_POST['post_desc'],
						// some simple key / value array
						'meta_input' => array(

							'_cpt_auftrag_fullnamedata_key'		=> $_POST['post_vorname'] . ' ' . $_POST['post_nachname'],
							'_cpt_auftrag_emaildata_key'		=> $_POST['post_email'],
							'_cpt_auftrag_einrichtungdata_key' 	=> $einrichtung_name,
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
				
				?>
					<script>
					$(document).ready(function(){
					$("#checkout").modal('show');
					let url = "<?php echo $new_url;?>"
					$("#checkout").on('hidden.bs.modal', function () {
						window.location = url
					});
					});
					</script>	

				<?php


				$meta_email_anfrage = get_post_meta($new_auftrag,'_cpt_auftrag_emaildata_key', true);
				$meta_email_fullname = get_post_meta($new_auftrag, '_cpt_auftrag_fullnamedata_key', true);
				$meta_email_booktitle = $_POST['post_title'];
				$multiple_recipients = array(
					$meta_email_anfrage,
					$einrichtung_mail
				);
				$subj = 'Ihre Bestellung';
				$body = $meta_email_fullname .' für Ihre Bestellung, der Artikel "'. $meta_email_booktitle .'" wurde für Sie reserviert.';
				wp_mail( $multiple_recipients, $subj, $body );

			} 
			// due to else - no footer

		?>

<?php get_footer(); 


			