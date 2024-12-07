<?php

namespace Core\Features\JsonConverter\UseCases;

use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\ArrayResult;

class ConvertJsonToArrayUseCase {
	/**
	 * @param mixed|null $value Value.
	 */
	public function invoke( $value ) {
		$encodeResult = JsonConverterApi::encode( $value );
		if ( false === $encodeResult->success ) {
			$result = new ArrayResult();
			$result = $result->copyExceptData( $encodeResult );
			return $result;
		}

		$decodeAsArrayResult = JsonConverterApi::decodeAsArray( $encodeResult->data );
		if ( $decodeAsArrayResult->success ) {
			$decodeAsArrayResult->message = sprintf( JsonConverterSuccessMessage::CONVERT_JSON_TO_ARRAY_SUCCESS );
		}

		return $decodeAsArrayResult;
	}
}
