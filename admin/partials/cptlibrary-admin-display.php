<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<body>
<main role="main">

<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading">Online-Buchverleih</h1>
    <p class="lead text-muted">Wählen Sie ihr Buch aus, tragen Sie ihren Namen ein und wählen Sie ihre Betriebsstätte aus. Danach klicken Sie auf Ausleihen und das Buch wird ihnen durch die Hauspost an ihren Arbeitsplatz geliefert.</p>
    <p>
      <a href="<?php echo get_admin_url( '', '/edit.php?post_type=cpt_books' ); ?>" class="btn btn-primary my-2">Bücher</a>
      <a href="<?php echo get_admin_url( '', '/edit.php?post_type=cpt_auftrag' ); ?>" class="btn btn-warning my-2">Aufträge</a>
      <a href="<?php echo get_admin_url( '', '/edit.php?post_type=cpt_einrichtung' ); ?>" class="btn btn-danger my-2">Einrichtungen</a>
    </p>
  </div>
</section>
</main>
</body>