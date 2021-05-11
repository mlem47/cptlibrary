<?php
/*
 * Template Name: New Template
 * Template Post Type: cpt_auftrag
 * 
 */ 

 get_header();?>

<div class="tinted-image">
	<div class="books-container">
		<div class="books-title">Unsere Online Bücherei</div>
			<div class="books-text"><b style="font-weight: 700;">So funktioniert es:</b><br>

Wählen Sie ihr Buch aus, tragen Sie ihren Namen ein und wählen Sie ihre Betriebsstätte aus. Danach klicken Sie auf Ausleihen und das Buch wird ihnen durch die Hauspost an ihren Arbeitsplatz geliefert.
			</div>
		</div>
	</div>
</div>

    <?  
        $post_id = get_the_ID();
        $fullname = get_post_meta($post_id,'_cpt_auftrag_fullnamedata_key', true);
        $email = get_post_meta( $post_id,'_cpt_auftrag_emaildata_key', true);
        $einrichtung = get_post_meta($post_id,'_cpt_auftrag_einrichtungdata_key', true);
        $nachricht = get_the_content( $post_id);
        $zeitraum = get_post_meta($post_id,'_cpt_auftrag_zeitraumdata_key', true);
        $zeitraum_end = get_post_meta($post_id,'_cpt_auftrag_zeitraumenddata_key', true);

    ?>  

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

 <div class="container boxpadding"> 
        <h1> Ausleihbestätigung </h1>
        
        <br>
       
        <div class="row">
			<div class="col-md-4">
				<div class="card">
                    <img class="card-img-top"> <?php the_post_thumbnail('large'); ?>
                    <div class="card-body">
                    <h3 class="card-title"><?php the_title() ?></h3>
                    </div>
				</div>	
			</div>
			<div class="col-md-8"> 
                    <h3>Ihre Daten</h3>
                    <p>Folgende Daten wurden für die Ausleihe gespeichert:</b>

                    <p>
                    <strong>Ihr Name:</strong> <? echo $fullname; ?> <br/>
                    </p>

                    <p>
                    <strong>Ihre E-Mail: </strong><? echo $email; ?><br />
                    </p>

                    <p>
                    <strong>Ihre Nachricht: </strong><? echo $nachricht; ?>
                    </p>

                    <p>
                    <strong>Ihre Einrichtung: </strong><? echo $einrichtung; ?>
                    </p>

                    <p>
                    <strong>Zeitraum: </strong><? echo $zeitraum; ?> 
                    </p>

                    <p>
                    <strong>Fällig am: </strong><? echo $zeitraum_end; ?>
                    </p>

                    <p>Das Buch wird Ihnen durch die Hauspost zugestellt. Für die Rückgabe wenden Sie sich an den für Sie zuständigen Sozialen Dienst.</p>

                    <div class="btn-auftrag">
                        <p><?php $url=home_url();?>
                            <a href="<?php echo $url;?>">
                                <button class="btn btn-danger btn-back">Zurück</button>
                            </a>
                        </p>
                    </div>
			</div>
            
        </div>	
     </div>	

    <?php endwhile; endif; ?>

   
<?php get_footer(); ?>