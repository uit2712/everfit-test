<?php

namespace Core\Features\JsonConverter\UseCases;

use Core\Features\JsonConverter\Facades\JsonConverter;

class EncodeJsonToStringUseCase {
	/**
	 * @param mixed|null $value Value.
	 */
	public function invoke( $value ) {
		return JsonConverter::getRepo()->encode( $value );
	}
}
