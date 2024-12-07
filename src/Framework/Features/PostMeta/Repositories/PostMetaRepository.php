<?php
namespace Framework\Features\PostMeta\Repositories;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Helpers\NumericHelper;
use Core\Helpers\StringHelper;
use Core\Models\IntegerResult;
use Core\Models\StringResult;
use Framework\Features\PostMeta\InterfaceAdapters\PostMetaRepositoryInterface;
use Framework\Helpers\PathHelper;

class PostMetaRepository implements PostMetaRepositoryInterface {
	public function getSingleValue( $postId, $key ): StringResult {
		$result = new StringResult();
		if ( NumericHelper::isPositiveInteger( $postId ) === false ) {
			$result->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'postId' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		if ( StringHelper::isHasValue( $key ) === false ) {
			$result->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'key' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		PathHelper::loadWordPressConfig();
		if ( function_exists( 'get_post_meta' ) === false ) {
			$result->message = sprintf( ErrorMessage::FUNCTION_NOT_EXISTS, 'get_post_meta' );
			return $result;
		}

		$data = get_post_meta( $postId, $key, true );
		if ( StringHelper::isHasValue( $data ) ) {
			$result->success = true;
			$result->data = StringHelper::trim( $data );
		}

		return $result;
	}

	public function getSingleValueAsInteger( $postId, $key ): IntegerResult {
		$result = new IntegerResult();
		$getDataResult = $this->getSingleValue( $postId, $key );
		$result = $result->copyExceptData( $getDataResult );
		$result->data = intval( $getDataResult->data );

		return $result;
	}
}
