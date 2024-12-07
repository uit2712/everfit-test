<?php

namespace Core\Features\JsonConverter\InterfaceAdapters;

use Core\Models\ArrayResult;
use Core\Models\Result;

interface JsonConverterRepositoryInterface {
	/**
	 * @param string|null $value Value.
	 */
	public function decode( $value ): Result;
	/**
	 * @param string|null $value Value.
	 */
	public function decodeAsArray( $value ): ArrayResult;
	/**
	 * @param mixed|null $value Value.
	 */
	public function encode( $value ): Result;
}
