<?php
namespace Core\Features\LinkLibrary\ViewModels;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Core\Helpers\StringHelper;
use Core\Models\Result;

class GetListLibraryLinksBySlugViewModel {
	public $slug = '';
	public $total = 0;

	public function __construct( $queryParams = array() ) {
		if ( ArrayHelper::isHasItems( $queryParams ) === false ) {
			return;
		}

		if ( isset( $queryParams['slug'] ) && StringHelper::isHasValue( $queryParams['slug'] ) ) {
			$this->slug = StringHelper::trim( $queryParams['slug'] );
		}

		if ( isset( $queryParams['total'] ) && NumericHelper::isPositiveInteger( $queryParams['total'] ) ) {
			$this->total = intval( $queryParams['total'] );
		}
	}

	public function validate() {
		$result = new Result();
		if ( StringHelper::isHasValue( $this->slug ) === false ) {
			$result->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'slug' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		if ( NumericHelper::isPositiveInteger( $this->total ) === false ) {
			$result->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'total' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$result->success = true;
		return $result;
	}
}
