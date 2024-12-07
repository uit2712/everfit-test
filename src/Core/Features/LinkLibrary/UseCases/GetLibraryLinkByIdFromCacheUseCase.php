<?php
namespace Core\Features\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\Cache\Facades\Cache;
use Core\Features\Cache\Traits\CacheSetterTrait;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\LinkLibrary\Facades\LinkLibraryApi;
use Core\Features\LinkLibrary\Models\GetLibraryLinkResult;
use Core\ViewModels\GetItemByIntegerIdViewModel;

class GetLibraryLinkByIdFromCacheUseCase {
	use CacheSetterTrait;

	/**
	 * @var GetLibraryLinkByIdUseCase
	 */
	private $getLibraryLinkByIdUseCase;

	public function __construct() {
		$this->getLibraryLinkByIdUseCase = LinkLibraryApi::getGetLibraryLinkByIdUseCaseInstance();
		$this->cache = Cache::getInstance();
	}

	public function setGetLibraryLinkByIdUseCaseInstance( $instance ) {
		if ( null !== $instance ) {
			$this->getLibraryLinkByIdUseCase = $instance;
		}
	}

	/**
	 * @OA\Get(
	 *      path="/api/v1/linkLibraries/GetLinkByIdFromCache.php",
	 *      summary="Get library link by id from cache",
	 *      tags={"Link libraries"},
	 *      @OA\Parameter(
	 *          in="query",
	 *          name="id",
	 *          description="Id",
	 *          required=true
	 *      ),
	 *      @OA\Response(
	 *          response="200",
	 *          description="Get library link by id from cache success",
	 *          @OA\MediaType(
	 *              mediaType="application/json",
	 *              @OA\Schema(ref="#/components/schemas/GetPostResult"),
	 *          )
	 *      )
	 * )
	 *
	 * @param GetItemByIntegerIdViewModel $model Model.
	 */
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

		$keyCache = sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $model->id );
		$getDataFromCacheResult = $this->cache->get( $keyCache );
		if ( null === $getDataFromCacheResult ) {
			$getDataResult = $this->getLibraryLinkByIdUseCase->invoke( $model );
			$result = $result->copyExceptData( $getDataResult );
			if ( false === $result->success ) {
				return $result;
			}

			$cacheItem = LinkLibrary::getCachedMapper()->mapFromEntityToCacheItem( $getDataResult->data );
			$storeDataToCacheResult = $this->cache->setMultiple( $cacheItem );
			if ( false === $storeDataToCacheResult ) {
				$result->success = false;
				$result->message = sprintf( ErrorMessage::STORE_DATA_TO_CACHE_FAILED );
				return $result;
			}

			$result->data = $getDataResult->data;
			return $result;
		}

		$result->data = LinkLibrary::getCachedMapper()->mapFromCacheToEntity( $getDataFromCacheResult );
		$result->success = null !== $result->data;
		if ( $result->success ) {
			$result->message = sprintf( LinkLibraryConstants::GET_LINK_BY_ID_FROM_CACHE_SUCCESS_MESSAGE );
		}

		return $result;
	}
}
