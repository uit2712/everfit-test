<?php
namespace Core\Features\LinkLibrary\Facades;

use Core\Features\LinkLibrary\UseCases\GetLibraryLinkByIdFromCacheUseCase;
use Core\Features\LinkLibrary\UseCases\GetLibraryLinkByIdUseCase;
use Core\Features\LinkLibrary\UseCases\GetListLibraryLinksBySlugFromCacheUseCase;
use Core\Features\LinkLibrary\UseCases\GetListLibraryLinksBySlugUseCase;
use Core\Features\LinkLibrary\ViewModels\GetListLibraryLinksBySlugViewModel;
use Core\ViewModels\GetItemByIntegerIdViewModel;

class LinkLibraryApi {
	/**
	 * @var GetListLibraryLinksBySlugUseCase|null
	 */
	private static $getListLibraryLinksBySlugUseCase;

	/**
	 * @var GetLibraryLinkByIdUseCase|null
	 */
	private static $getLibraryLinkByIdUseCase;

	/**
	 * @var GetLibraryLinkByIdFromCacheUseCase|null
	 */
	private static $getLibraryLinkByIdFromCacheUseCase;

	/**
	 * @var GetListLibraryLinksBySlugFromCacheUseCase|null
	 */
	private static $getListLibraryLinksBySlugFromCacheUseCase;

	public static function getGetListLibraryLinksBySlugUseCaseInstance() {
		if ( null === self::$getListLibraryLinksBySlugUseCase ) {
			self::$getListLibraryLinksBySlugUseCase = new GetListLibraryLinksBySlugUseCase();
		}

		return self::$getListLibraryLinksBySlugUseCase;
	}

	public static function getLinksBySlug( $queryParams ) {
		$model = new GetListLibraryLinksBySlugViewModel( $queryParams );

		return self::getGetListLibraryLinksBySlugUseCaseInstance()->invoke( $model );
	}

	public static function getGetLibraryLinkByIdUseCaseInstance() {
		if ( null === self::$getLibraryLinkByIdUseCase ) {
			self::$getLibraryLinkByIdUseCase = new GetLibraryLinkByIdUseCase();
		}

		return self::$getLibraryLinkByIdUseCase;
	}

	public static function getLinkById( $queryParams ) {
		$model = new GetItemByIntegerIdViewModel( $queryParams );

		return self::getGetLibraryLinkByIdUseCaseInstance()->invoke( $model );
	}

	public static function getGetLibraryLinkByIdFromCacheUseCaseInstance() {
		if ( null === self::$getLibraryLinkByIdFromCacheUseCase ) {
			self::$getLibraryLinkByIdFromCacheUseCase = new GetLibraryLinkByIdFromCacheUseCase();
		}

		return self::$getLibraryLinkByIdFromCacheUseCase;
	}

	public static function getLinkByIdFromCache( $queryParams ) {
		$model = new GetItemByIntegerIdViewModel( $queryParams );

		return self::getGetLibraryLinkByIdFromCacheUseCaseInstance()->invoke( $model );
	}

	public static function getGetListLibraryLinksBySlugFromCacheUseCaseInstance() {
		if ( null === self::$getListLibraryLinksBySlugFromCacheUseCase ) {
			self::$getListLibraryLinksBySlugFromCacheUseCase = new GetListLibraryLinksBySlugFromCacheUseCase();
		}

		return self::$getListLibraryLinksBySlugFromCacheUseCase;
	}

	public static function getLinksBySlugFromCache( $queryParams ) {
		$model = new GetListLibraryLinksBySlugViewModel( $queryParams );

		return self::getGetListLibraryLinksBySlugFromCacheUseCaseInstance()->invoke( $model );
	}
}
