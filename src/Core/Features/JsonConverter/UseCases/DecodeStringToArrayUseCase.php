<?php

namespace Core\Features\JsonConverter\UseCases;

use Core\Features\JsonConverter\Facades\JsonConverter;

class DecodeStringToArrayUseCase {
	/**
	 * @param string|null $value Value.
	 */
	public function invoke( $value ) {
		return JsonConverter::getRepo()->decodeAsArray( $value );
	}
}
