<?php

namespace Core\Features\JsonConverter\Repositories;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\InterfaceAdapters\JsonConverterRepositoryInterface;
use Core\Helpers\StringHelper;
use Core\Models\ArrayResult;
use Core\Models\Result;

class JsonConverterRepository implements JsonConverterRepositoryInterface {
	public function decode( $value ): Result {
		$result = new Result();

		if ( StringHelper::isHasValue( $value ) === false ) {
			$result->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'value' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$value = json_decode( $value );
		if ( false === $value || null === $value ) {
			$result->message = sprintf( JsonConverterErrorMessage::CAN_NOT_DECODE_STRING );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$result->success = true;
		$result->message = sprintf( JsonConverterSuccessMessage::DECODE_STRING_TO_JSON_SUCCESS );
		$result->data = $value;

		return $result;
	}

	public function decodeAsArray( $value ): ArrayResult {
		$result = new ArrayResult();

		if ( StringHelper::isHasValue( $value ) === false ) {
			$result->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'value' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$value = json_decode( $value, true );
		if ( is_array( $value ) === false ) {
			$result->message = sprintf( JsonConverterErrorMessage::CAN_NOT_DECODE_STRING );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$result->success = true;
		$result->message = sprintf( JsonConverterSuccessMessage::DECODE_STRING_TO_ARRAY_SUCCESS );
		$result->data = $value;

		return $result;
	}

	public function encode( $value ): Result {
		$result = new Result();

		if (
			is_object( $value ) === false &&
			is_array( $value ) === false &&
			is_numeric( $value ) === false &&
			is_string( $value ) === false
		) {
			$result->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'value' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$result->success = true;
		$result->message = sprintf( JsonConverterSuccessMessage::ENCODE_JSON_TO_STRING_SUCCESS );
		if ( is_string( $value ) && empty( trim( $value ) ) ) {
			$result->data = '';
		} else {
			$result->data = json_encode( $value );
		}

		return $result;
	}
}
