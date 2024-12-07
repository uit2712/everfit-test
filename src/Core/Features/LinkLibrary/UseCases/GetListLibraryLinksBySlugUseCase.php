<?php
namespace Core\Features\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\LinkLibrary\Models\GetListLibraryLinksResult;
use Core\Features\LinkLibrary\Traits\LinkLibraryMapperSetterTrait;
use Core\Features\LinkLibrary\Traits\LinkLibraryRepositorySetterTrait;
use Core\Features\LinkLibrary\ViewModels\GetListLibraryLinksBySlugViewModel;
use Core\Features\Post\Facades\Post;
use Core\Helpers\ArrayHelper;

class GetListLibraryLinksBySlugUseCase {
	use LinkLibraryRepositorySetterTrait;
	use LinkLibraryMapperSetterTrait;

	public function __construct() {
		$this->linkLibraryRepo = LinkLibrary::getRepo();
		$this->linkLibraryMapper = LinkLibrary::getMapper();
	}

	/**
	 * @OA\Get(
	 *      path="/api/v1/linkLibraries/GetLinksBySlug.php",
	 *      summary="Get list links by slug",
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
	 *          description="Get list links by slug success",
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

		$getDataResult = $this->linkLibraryRepo->getLinksBySlug( $model->slug, $model->total );
		if ( false === $getDataResult->success ) {
			$result = $result->copyExceptData( $getDataResult );
			return $result;
		}

		$listPosts = Post::getMapper()->mapFromDbToListEntities( $getDataResult->data );
		$listPosts = $this->linkLibraryMapper->mapFromListPostEntitiesToListEntities( $listPosts );
		$result->data = $listPosts;
		$result->success = ArrayHelper::isHasItems( $result->data );

		return $result;
	}
}
