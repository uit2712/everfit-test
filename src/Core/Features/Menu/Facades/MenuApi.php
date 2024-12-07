<?php
namespace Core\Features\Menu\Facades;

use Core\Features\Menu\UseCases\GetMainMenuByLocationUseCase;
use Core\Features\Menu\ViewModels\GetMainMenuByLocationViewModel;

class MenuApi {
	/**
	 * @var GetMainMenuByLocationUseCase
	 */
	private static $getMainMenuByLocationUseCase;

	public static function getMainMenuByLocation( $queryParams ) {
		$model = new GetMainMenuByLocationViewModel( $queryParams );

		if ( null === self::$getMainMenuByLocationUseCase ) {
			self::$getMainMenuByLocationUseCase = new GetMainMenuByLocationUseCase();
		}

		return self::$getMainMenuByLocationUseCase->invoke( $model );
	}
}
