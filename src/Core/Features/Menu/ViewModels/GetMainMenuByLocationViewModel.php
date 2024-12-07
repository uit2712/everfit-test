<?php
namespace Core\Features\Menu\ViewModels;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Helpers\ArrayHelper;
use Core\Helpers\StringHelper;
use Core\Models\Result;

class GetMainMenuByLocationViewModel {
	public $location = '';

	public function __construct( $queryParams = array() ) {
		if ( ArrayHelper::isHasItems( $queryParams ) === false ) {
			return;
		}

		if ( isset( $queryParams['location'] ) && StringHelper::isHasValue( $queryParams['location'] ) ) {
			$this->location = StringHelper::trim( $queryParams['location'] );
		}
	}

	public function validate() {
		$result = new Result();
		if ( StringHelper::isHasValue( $this->location ) === false ) {
			$result->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'location' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$result->success = true;
		return $result;
	}
}
