<?php
namespace Core\Features\Post\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\Post\Constants\PostConstants;
use Core\Features\Post\Facades\Post;
use Core\Features\Post\Models\GetPostResult;
use Core\ViewModels\GetItemByIntegerIdViewModel;
use Framework\Features\WordPressQuery\Facades\WordPressQuery;
use Framework\Features\WordPressQuery\Traits\WordPressQueryRepositorySetterTrait;

class GetPostByIdUseCase {
	use WordPressQueryRepositorySetterTrait;

	public function __construct() {
		$this->wpQueryRepo = WordPressQuery::getInstance();
	}

	/**
	 * @OA\Get(
	 *      path="/api/v1/posts/GetById.php",
	 *      summary="Get post by id",
	 *      tags={"Posts"},
	 *      @OA\Parameter(
	 *          in="query",
	 *          name="id",
	 *          description="Id",
	 *          required=true
	 *      ),
	 *      @OA\Response(
	 *          response="200",
	 *          description="Get post by id success",
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
		$result = new GetPostResult();
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

		$data = $this->wpQueryRepo->getPostById( $model->id );
		$result->success = null !== $data;
		if ( false === $result->success ) {
			$result->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, PostConstants::ITEM_NAME );
			$result->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
			return $result;
		}

		$result->data = Post::getMapper()->mapFromDbToEntity( $data );

		return $result;
	}
}
