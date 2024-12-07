<?php
get_header();
?>
<main>
	<section class="sec-background"></section>
	<?php \Presentation\Helpers\ViewHelper::render( 'Views/Pages/Home/Introduction.php' ); ?>
	<?php \Presentation\Helpers\ViewHelper::render( 'Views/Pages/Home/TrustedCompanies.php' ); ?>
	<?php \Presentation\Helpers\ViewHelper::render( 'Views/Pages/Home/CoachesFeebacks.php' ); ?>
</main>
<?php
get_footer();
