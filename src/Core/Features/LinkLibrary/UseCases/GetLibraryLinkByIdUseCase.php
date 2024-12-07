<?php
namespace Core\Features\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\LinkLibrary\Models\GetLibraryLinkResult;
use Core\Features\LinkLibrary\Traits\LinkLibraryMapperSetterTrait;
use Core\Features\Post\Facades\PostApi;
use Core\Features\Post\Traits\GetPostByIdUseCaseSetterTrait;
use Core\ViewModels\GetItemByIntegerIdViewModel;

class GetLibraryLinkByIdUseCase {
	use GetPostByIdUseCaseSetterTrait;
	use LinkLibraryMapperSetterTrait;

	public function __construct() {
		$this->getPostByIdUseCase = PostApi::getPostByIdUseCaseInstance();
		$this->linkLibraryMapper = LinkLibrary::getMapper();
	}

	public function invoke( $model ) {
		$result = new GetLibraryLinkResult();
		if ( null === $model || false === ( $model instanceof GetItemByIntegerIdViewModel ) ) {
			$result->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'model' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$validateResult = $model->validate();
		if ( false === $validateResult->success ) {
			$result = $result->copyExceptData( $validateResult );
			return $result;
		}

		$getDataResult = $this->getPostByIdUseCase->invoke( $model );
		$result = $result->copyExceptData( $getDataResult );
		if ( false === $getDataResult->success ) {
			$result->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
			$result->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
			return $result;
		}

		$result->data = $this->linkLibraryMapper->mapFromPostEntityToEntity( $getDataResult->data );

		return $result;
	}
}
