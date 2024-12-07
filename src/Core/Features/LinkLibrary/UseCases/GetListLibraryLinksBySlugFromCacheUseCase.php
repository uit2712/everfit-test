<?php
namespace Core\Features\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\Cache\Facades\Cache;
use Core\Features\Cache\Traits\CacheSetterTrait;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\LinkLibrary\Facades\LinkLibraryApi;
use Core\Features\LinkLibrary\Models\GetListLibraryLinksResult;
use Core\Features\LinkLibrary\ViewModels\GetListLibraryLinksBySlugViewModel;
use Core\Helpers\ArrayHelper;
use Core\ViewModels\GetItemByIntegerIdViewModel;

class GetListLibraryLinksBySlugFromCacheUseCase {
	use CacheSetterTrait;

	/**
	 * @var GetListLibraryLinksBySlugUseCase|null
	 */
	private $getListLibraryLinksBySlugUseCase;

	/**
	 * @var GetLibraryLinkByIdFromCacheUseCase|null
	 */
	private $getLibraryLinkByIdFromCacheUseCase;

	public function __construct() {
		$this->cache = Cache::getInstance();
		$this->getListLibraryLinksBySlugUseCase = LinkLibraryApi::getGetListLibraryLinksBySlugUseCaseInstance();
		$this->getLibraryLinkByIdFromCacheUseCase = LinkLibraryApi::getGetLibraryLinkByIdFromCacheUseCaseInstance();
	}

	public function setGetListLibraryLinksBySlugUseCaseInstance( $instance ) {
		if ( null !== $instance ) {
			$this->getListLibraryLinksBySlugUseCase = $instance;
		}
	}

	public function setGetLibraryLinkByIdFromCacheUseCaseInstance( $instance ) {
		if ( null !== $instance ) {
			$this->getLibraryLinkByIdFromCacheUseCase = $instance;
		}
	}

	/**
	 * @OA\Get(
	 *      path="/api/v1/linkLibraries/GetLinksBySlugFromCache.php",
	 *      summary="Get list links by slug from cache",
	 *      tags={"Link libraries"},
	 *      @OA\Parameter(
	 *          in="query",
	 *          name="slug",
	 *          description="Slug",
	 *          required=true,
	 *          @OA\Schema(
	 *              default="",
	 *              type="string",
	 *              enum={"", "mang-xa-hoi"}
	 *          ),
	 *      ),
	 *      @OA\Parameter(
	 *          in="query",
	 *          name="total",
	 *          description="Total",
	 *          example="10",
	 *          required=true
	 *      ),
	 *      @OA\Response(
	 *          response="200",
	 *          description="Get list links by slug from cache success",
	 *          @OA\MediaType(
	 *              mediaType="application/json",
	 *              @OA\Schema(ref="#/components/schemas/GetListLibraryLinksResult"),
	 *          )
	 *      )
	 * )
	 *
	 * @param GetListLibraryLinksBySlugViewModel $model Model.
	 */
	public function invoke( $model ) {
		$result = new GetListLibraryLinksResult();
		if ( null === $model || false === ( $model instanceof GetListLibraryLinksBySlugViewModel ) ) {
			$result->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'model' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$validateResult = $model->validate();
		if ( false === $validateResult->success ) {
			$result = $result->copyExceptData( $validateResult );
			return $result;
		}

		$keyCache = sprintf(
			LinkLibraryConstants::GET_LIST_LINKS_BY_SLUG_KEY_CACHE,
			$model->slug,
			$model->total
		);
		$listIds = $this->cache->get( $keyCache, array() );
		if ( ArrayHelper::isHasItems( $listIds ) === false ) {
			$getDataResult = $this->getListLibraryLinksBySlugUseCase->invoke( $model );
			if ( false === $getDataResult->success ) {
				$result = $result->copyExceptData( $getDataResult );
				return $result;
			}

			$listCacheItems = LinkLibrary::getCachedMapper()->mapFromListEntitiesToListCacheItems(
				$keyCache,
				$getDataResult->data,
			);
			$storeDataToCacheResult = $this->cache->setMultiple( $listCacheItems );
			if ( false === $storeDataToCacheResult ) {
				$result->message = sprintf( ErrorMessage::STORE_DATA_TO_CACHE_FAILED );
				return $result;
			}

			$result->success = true;
			$result->data = $getDataResult->data;
			return $result;
		}

		$listIdsKeyCaches = array_map(
			function ( $id ) {
				return sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $id );
			},
			$listIds,
		);
		$getDataFromCacheResult = $this->cache->getMultipleKeepKeys( $listIdsKeyCaches );
		foreach ( $getDataFromCacheResult as $keyCache => $item ) {
			if ( null !== $item ) {
				$mappedItem = LinkLibrary::getCachedMapper()->mapFromCacheToEntity( $item );
				if ( null !== $mappedItem ) {
					$result->data[] = $mappedItem;
				}
			} else {
				[$_, $id] = explode( ':', $keyCache );
				$getDataFromDbModel = new GetItemByIntegerIdViewModel( array( 'id' => $id ) );
				$getDataFromDbResult = $this->getLibraryLinkByIdFromCacheUseCase->invoke( $getDataFromDbModel );
				if ( $getDataFromDbResult->isHasObjectData() ) {
					$result->data[] = $getDataFromDbResult->data;
				}
			}
		}

		$result->success = ArrayHelper::isHasItems( $result->data );
		$result->message = sprintf( LinkLibraryConstants::GET_LINKS_BY_SLUG_FROM_CACHE_SUCCESS_MESSAGE );

		return $result;
	}
}
