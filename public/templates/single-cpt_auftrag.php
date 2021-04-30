<?php
/*
 * Template Name: New Template
 * Template Post Type: cpt_auftrag
 * 
 */ 

 get_header();?>

    <?  
        $post_id = get_the_ID();
        $fullname = get_post_meta($post_id,'_cpt_auftrag_fullnamedata_key', true);
        $email = get_post_meta( $post_id,'_cpt_auftrag_emaildata_key', true);
        $einrichtung = get_post_meta($post_id,'_cpt_auftrag_einrichtungdata_key', true);
        $nachricht = get_the_content( $post_id);
        $zeitraum = get_post_meta($post_id,'_cpt_auftrag_zeitraumdata_key', true);
        $zeitraum_end = get_post_meta($post_id,'_cpt_auftrag_zeitraum_enddata_key', true);
    ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

 <div class="container boxpadding"> 
        <h1> Ausleihbestätigung </h1>
        
        <br>
       
        <div class="row">
			<div class="col-md-4">
				<div class="card" style="width: 20rem;">
                    <img class="card-img-top"> <?php the_post_thumbnail('large'); ?>
                    <div class="card-body">
                    <h3 class="card-title"><?php the_title() ?></h3>
                    </div>
				</div>	
			</div>
			<div class="col-md-8">                 
                <div class="col">
                    <h3>Ihre Daten</h3>

                    <p>
                    Ihr Name: <strong><? echo $fullname; ?> </strong><br/>
                    </p>

                    <p>
                    Ihre E-Mail: <strong><? echo $email; ?></strong><br />
                    </p>

                    <p>
                    Ihre Nachricht: <strong><? echo $nachricht; ?></strong>
                    </p>

                    <p>Ihre Einrichtung: <strong><? echo $einrichtung; ?></strong>
                    </p>

                    <p>
                    Zeitraum: <strong><? echo $zeitraum; ?> </strong>
                    </p>

                    <p>
                    Fällig am: <strong><? echo $zeitraum_end; ?></strong>
                    </p>
                </div>
			</div>
        </div>	
     </div>	

    <?php endwhile; endif; ?>

    <?
    $id = get_the_ID($post);
	$fullname = get_post_meta($id,'_cpt_auftrag_fullnamedata_key', true);
	$email = get_post_meta( $id,'_cpt_auftrag_emaildata_key', true);
	$einrichtung = get_post_meta($id,'_cpt_auftrag_einrichtungdata_key', true);
	$zeitraum = get_post_meta($id,'_cpt_auftrag_zeitraumdata_key', true);
	$zeitraum_end = get_post_meta($id,'_cpt_auftrag_zeitraumenddata_key', true);
    ?>



<?php get_footer(); ?>