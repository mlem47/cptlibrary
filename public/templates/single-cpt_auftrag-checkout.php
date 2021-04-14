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



<?php get_footer(); ?>