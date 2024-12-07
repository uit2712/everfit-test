<?php
namespace Core\Features\Menu\InterfaceAdapters;

use Core\Features\Menu\Models\GetListMenuItemsResult;
use Core\Features\Menu\Models\GetMenuResult;

interface MenuRepositoryInterface {
	/**
	 * @param string|null $location Menu location.
	 */
	public function getMainMenuByLocation( $location ): GetMenuResult;

	/**
	 * @param int|null $id Menu id.
	 */
	public function getListMenuItemsOfMenu( $id ): GetListMenuItemsResult;
}
