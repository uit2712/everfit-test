<?php
namespace Core\Features\Post\Facades;

use Core\Features\Post\InterfaceAdapters\PostMapperInterface;
use Core\Features\Post\Mappers\PostMapper;
use Core\Features\Post\UseCases\GetPostByIdUseCase;
use Core\ViewModels\GetItemByIntegerIdViewModel;

class PostApi {
	/**
	 * @var GetPostByIdUseCase|null
	 */
	private static $getPostByIdUseCase;

	public static function getPostByIdUseCaseInstance() {
		if ( null === self::$getPostByIdUseCase ) {
			self::$getPostByIdUseCase = new GetPostByIdUseCase();
		}

		return self::$getPostByIdUseCase;
	}

	public static function getById( $queryParams = array() ) {
		$model = new GetItemByIntegerIdViewModel( $queryParams );

		return self::getPostByIdUseCaseInstance()->invoke( $model );
	}
}
