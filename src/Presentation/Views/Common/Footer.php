<?php

use Core\Features\LinkLibrary\Facades\LinkLibraryApi;

$listSocialNetworks = LinkLibraryApi::getLinksBySlug(
	array(
		'slug' => 'social-networks',
		'total' => 10,
	)
)->data;

?>

<footer>
	<div class="inner">
		<p>Made with ❤️ in San Francisco © Everfit 2020 - All Rights Reserved.</p>
		<div class="social-networks">
			<?php foreach ( $listSocialNetworks as $item ) : ?>
				<a href="<?php echo $item->url; ?>" title="<?php echo $item->title; ?>">
					<i class="<?php echo $item->description; ?>"></i>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</footer>
