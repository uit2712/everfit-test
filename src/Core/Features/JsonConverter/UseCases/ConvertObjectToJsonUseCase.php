<?php

namespace Core\Features\JsonConverter\UseCases;

use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\Result;

class ConvertObjectToJsonUseCase {
	/**
	 * @param mixed|null $value Value.
	 */
	public function invoke( $value ) {
		$encodeResult = JsonConverterApi::encode( $value );
		if ( false === $encodeResult->success ) {
			$result = new Result();
			$result = $result->copyExceptData( $encodeResult );
			return $result;
		}

		$decodeResult = JsonConverterApi::decode( $encodeResult->data );
		if ( $decodeResult->success ) {
			$decodeResult->message = sprintf( JsonConverterSuccessMessage::CONVERT_OBJECT_TO_JSON_SUCCESS );
		}

		return $decodeResult;
	}
}
