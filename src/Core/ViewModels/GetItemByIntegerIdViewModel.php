<?php

namespace Core\ViewModels;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Core\Models\Result;

class GetItemByIntegerIdViewModel {
	public $id = 0;

	public function __construct( $queryParams = array() ) {
		if ( ArrayHelper::isHasItems( $queryParams ) === false ) {
			return;
		}

		if ( isset( $queryParams['id'] ) && NumericHelper::isPositiveInteger( $queryParams['id'] ) ) {
			$this->id = NumericHelper::parseInteger( $queryParams['id'] );
		}
	}

	public function validate() {
		$result = new Result();
		if ( NumericHelper::isPositiveInteger( $this->id ) === false ) {
			$result->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'id' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$result->success = true;
		return $result;
	}
}
