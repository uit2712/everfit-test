<?php
namespace Core\Helpers;

use Core\Constants\ApiResponseCode;
use Core\Models\Result;

class ResponseHelper {
	public static function renderJson( $data, $responseCode = ApiResponseCode::HTTP_OK ) {
		header( 'Content-Type: application/json' );
		http_response_code( $responseCode );
		echo json_encode( $data );
		exit();
	}

	public static function renderXml( $data, $responseCode = ApiResponseCode::HTTP_OK ) {
		header( 'Content-Type: text/xml' );
		http_response_code( $responseCode );
		// phpcs:ignore
		echo $data;
		exit();
	}

	public static function checkAllowMethods( array $methods ) {
        // phpcs:ignore
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		if ( in_array( $httpMethod, $methods, true ) === false ) {
			$result = new Result();
			$result->message = 'Unsupport method';
			$result->responseCode = ApiResponseCode::HTTP_METHOD_NOT_ALLOWED;
			self::renderJson( $result, $result->responseCode );
		}
	}
}
