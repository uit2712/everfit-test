<?php
namespace Framework\Features\Menu\Repositories;

use Core\Constants\ErrorMessage;
use Core\Helpers\StringHelper;
use Core\Features\Menu\InterfaceAdapters\MenuRepositoryInterface;
use Core\Features\Menu\Models\GetListMenuItemsResult;
use Core\Features\Menu\Models\GetMenuResult;
use Framework\Helpers\PathHelper;

class MenuRepository implements MenuRepositoryInterface {
	public function getMainMenuByLocation( $location ): GetMenuResult {
		$result = new GetMenuResult();
		if ( StringHelper::isHasValue( $location ) === false ) {
			$result->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'location' );
			return $result;
		}

		PathHelper::loadWordPressConfig();
		if ( function_exists( 'get_nav_menu_locations' ) === false ) {
			$result->message = sprintf( ErrorMessage::FUNCTION_NOT_EXISTS, 'get_nav_menu_locations' );
			return $result;
		}

		$listLocations = $this->getAllMenuLocations();
		if ( null === $listLocations[ $location ] ) {
			$result->message = sprintf( 'Not found menu' );
			return $result;
		}

		$termId = $listLocations[ $location ];
		$result->success = true;
		$result->data = get_term( $termId );
		$result->message = sprintf( 'Get menu by location %s success', $location );

		return $result;
	}

	private function getAllMenuLocations() {
		PathHelper::loadWordPressConfig();
		if ( function_exists( 'get_nav_menu_locations' ) === false ) {
			return array();
		}

		$listLocations = get_nav_menu_locations();

		return $listLocations;
	}

	public function getListMenuItemsOfMenu( $location ): GetListMenuItemsResult {
		$result = new GetListMenuItemsResult();

		$getMenuResult = $this->getMainMenuByLocation( $location );
		if ( $getMenuResult->isHasObjectData() === false ) {
			$result = $result->copyExceptData( $getMenuResult );
			return $result;
		}

		PathHelper::loadWordPressConfig();
		if ( function_exists( 'wp_get_nav_menu_items' ) === false ) {
			$result->message = sprintf( ErrorMessage::FUNCTION_NOT_EXISTS, 'wp_get_nav_menu_items' );
			return $result;
		}

		$menuItems = wp_get_nav_menu_items( $getMenuResult->data->id );
		if ( false === $menuItems ) {
			$result->message = 'Not found menu items';
			return $result;
		}

		$result->success = true;
		$result->data = json_decode( json_encode( $menuItems ) );
		$result->data = $menuItems;

		return $result;
	}
}
