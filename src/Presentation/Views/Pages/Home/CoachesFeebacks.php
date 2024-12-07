<?php

use Core\Features\LinkLibrary\Facades\LinkLibraryApi;

$listItems = LinkLibraryApi::getLinksBySlug(
	array(
		'slug' => 'coaches-feedbacks',
		'total' => 10,
	)
)->data;
?>
<section class="sec-coaches-feedbacks">
	<p class="title">Our Coaches Love Us</p>
	<div class="slider-coaches-feedbacks">
		<?php foreach ( $listItems as $item ) : ?>
			<div class="slider-item">
				<div class="image-container">
					<img src="<?php echo $item->image; ?>" alt="<?php echo $item->title; ?>" height="371px" width="278px" />
				</div>
				<div class="description">
					<div class="detail"><?php echo $item->largeDescription; ?></div>
					<div>
						<p class="name"><?php echo $item->title; ?></p>
						<p class="extra"><?php echo $item->description; ?> @ <span class="role"><?php echo $item->notes; ?></span></p>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
