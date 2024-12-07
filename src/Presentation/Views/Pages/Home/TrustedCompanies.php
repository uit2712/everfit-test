<?php

use Core\Features\LinkLibrary\Facades\LinkLibraryApi;

$listItems = LinkLibraryApi::getLinksBySlug(
	array(
		'slug' => 'trusted-team',
		'total' => 10,
	)
)->data;
?>
<section class="sec-trusted-companies">
	<?php foreach ( $listItems as $item ) : ?>
		<img src="<?php echo $item->image; ?>" alt="<?php echo $item->title; ?>" width="auto" height="38px" />
	<?php endforeach; ?>
</section>
