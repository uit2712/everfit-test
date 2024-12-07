<?php

use Core\Features\Menu\Facades\MenuApi;
use Framework\Features\Menu\Constants\MenuLocationConstants;

$listMenuItems = MenuApi::getListItemsOfMenuByLocation(
	array(
		'location' => MenuLocationConstants::PRIMARY,
	)
)->data;
?>
<nav role="navigation" aria-label="Main menu">
	<ul>
		<?php foreach ( $listMenuItems as $item ) : ?>
			<li><?php echo $item->title; ?></li>
		<?php endforeach; ?>
	</ul>
</nav>
