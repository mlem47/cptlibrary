<? get_header() ?>
<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
<? get_footer() ?> 



<?php get_header(); ?>

 
       
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="container">

		<hr>
		
		<div>
			<div class="row mb-2">
				<div class="col">
				<div class="card flex-md-row mb-4 box-shadow h-md-250">
						<div class="card-body d-flex flex-column align-items-start">
						<h2 class="mb-0">
						<a class="text-dark" href="<?php the_permalink() ?>"><?php the_title() ?></a>
						</h2>
						</div>
						<?php the_post_thumbnail()?>
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
			<div class="row mb-2">
			<div class="col">
				<form name="post-job" method="post" action="" >
							<script>
								jQuery(document).ready(function($) {
									$("#startdatepicker").datepicker();
									
								});
							</script>
							<p>Anfangsdatum:<div id="startdatepicker"></div></p> 

						
			</div><!-- column -->	
							
			<div class="col">
						<script>
							jQuery(document).ready(function($) {
								$("#enddatepicker").datepicker();
							});
						</script>
								<p>Enddatum:<div id="enddatepicker"></div></p> 
						</div>
					</div>
				</form>
			</div><!-- column -->
				
			




				<div class="col">
				<form>		
						<div class="form-group">
							<label for="formGroupExampleInput">Vorname</label>
							<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Vorname">
						</div>

						<div class="form-group">
							<label for="formGroupExampleInput2">Nachname</label>
							<input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Nachname">
						</div>

						<div class="form-group">
							<label for="exampleInputEmail1">Email Adresse</label>
							<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email Adresse">
						</div>
						</form>
						
		
						<hr>
						<button type="submit" class="btn btn-primary">Ausleihen</button>

					</form>
						
				</div><!-- column -->
				
			
			</div><!--row-->
		</div>

	</div><!-- container -->


	<?php endwhile; endif; ?>
	

   
<?php get_footer(); ?>