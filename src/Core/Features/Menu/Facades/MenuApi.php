<?php
namespace Core\Features\Menu\Facades;

use Core\Features\Menu\UseCases\GetListMenuItemsOfMenuByLocationUseCase;
use Core\Features\Menu\UseCases\GetMainMenuByLocationUseCase;
use Core\Features\Menu\ViewModels\GetListMenuItemsOfMenuByLocationViewModel;
use Core\Features\Menu\ViewModels\GetMainMenuByLocationViewModel;

class MenuApi {
	/**
	 * @var GetMainMenuByLocationUseCase
	 */
	private static $getMainMenuByLocationUseCase;

	/**
	 * @var GetListMenuItemsOfMenuByLocationUseCase
	 */
	private static $getListMenuItemsOfMenuByLocationUseCase;

	public static function getMainMenuByLocation( $queryParams ) {
		$model = new GetMainMenuByLocationViewModel( $queryParams );

		if ( null === self::$getMainMenuByLocationUseCase ) {
			self::$getMainMenuByLocationUseCase = new GetMainMenuByLocationUseCase();
		}

		return self::$getMainMenuByLocationUseCase->invoke( $model );
	}

	public static function getListItemsOfMenuByLocation( $queryParams ) {
		$model = new GetListMenuItemsOfMenuByLocationViewModel( $queryParams );

		if ( null === self::$getListMenuItemsOfMenuByLocationUseCase ) {
			self::$getListMenuItemsOfMenuByLocationUseCase = new GetListMenuItemsOfMenuByLocationUseCase();
		}

		return self::$getListMenuItemsOfMenuByLocationUseCase->invoke( $model );
	}
}
