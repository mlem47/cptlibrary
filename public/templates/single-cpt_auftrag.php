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
       
        <div class="row mb-2">
            <div class="col">
            <?php the_post_thumbnail('medium')?>
        </div>

        <div class="col">

            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <h2 class="mb-0">
                    Sie haben erfolgreich<br><br>"<?php the_title() ?>" reserviert!
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

    <?
    $id = get_the_ID($post);
	$fullname = get_post_meta($id,'_cpt_auftrag_fullnamedata_key', true);
	$email = get_post_meta( $id,'_cpt_auftrag_emaildata_key', true);
	$einrichtung = get_post_meta($id,'_cpt_auftrag_einrichtungdata_key', true);
	$zeitraum = get_post_meta($id,'_cpt_auftrag_zeitraumdata_key', true);
	$zeitraum_end = get_post_meta($id,'_cpt_auftrag_zeitraumenddata_key', true);
    ?>



    <form id="post_entry" name="post_entry" method="post" action="">
        <div class ="form-group">
            <p>
            Ihre Daten:
            </p>

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
	</form>
</div>






<?php get_footer(); ?>