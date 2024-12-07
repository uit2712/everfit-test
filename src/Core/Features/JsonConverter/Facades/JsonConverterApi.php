<?php

namespace Core\Features\JsonConverter\Facades;

use Core\Features\JsonConverter\UseCases\ConvertJsonToArrayUseCase;
use Core\Features\JsonConverter\UseCases\ConvertObjectToJsonUseCase;
use Core\Features\JsonConverter\UseCases\DecodeStringToArrayUseCase;
use Core\Features\JsonConverter\UseCases\DecodeStringToJsonUseCase;
use Core\Features\JsonConverter\UseCases\EncodeJsonToStringUseCase;

class JsonConverterApi {

	/**
	 * @var DecodeStringToJsonUseCase|null
	 */
	private static $decodeStringToJsonUseCase;

	/**
	 * @var EncodeJsonToStringUseCase|null
	 */
	private static $encodeJsonToStringUseCase;

	/**
	 * @var DecodeStringToArrayUseCase|null
	 */
	private static $decodeStringToArrayUseCase;

	/**
	 * @var ConvertJsonToArrayUseCase|null
	 */
	private static $convertJsonToArrayUseCase;

	/**
	 * @var ConvertObjectToJsonUseCase|null
	 */
	private static $convertObjectToJsonUseCase;

	/**
	 * @param string|null $value Value.
	 */
	public static function decode( $value ) {
		if ( null === self::$decodeStringToJsonUseCase ) {
			self::$decodeStringToJsonUseCase = new DecodeStringToJsonUseCase();
		}

		return self::$decodeStringToJsonUseCase->invoke( $value );
	}

	/**
	 * @param mixed|null $value Value.
	 */
	public static function encode( $value ) {
		if ( null === self::$encodeJsonToStringUseCase ) {
			self::$encodeJsonToStringUseCase = new EncodeJsonToStringUseCase();
		}

		return self::$encodeJsonToStringUseCase->invoke( $value );
	}

	/**
	 * @param string|null $value Value.
	 */
	public static function decodeAsArray( $value ) {
		if ( null === self::$decodeStringToArrayUseCase ) {
			self::$decodeStringToArrayUseCase = new DecodeStringToArrayUseCase();
		}

		return self::$decodeStringToArrayUseCase->invoke( $value );
	}

	/**
	 * @param mixed|null $value Value.
	 */
	public static function convertToArray( $value ) {
		if ( null === self::$convertJsonToArrayUseCase ) {
			self::$convertJsonToArrayUseCase = new ConvertJsonToArrayUseCase();
		}

		return self::$convertJsonToArrayUseCase->invoke( $value );
	}

	/**
	 * @param mixed|null $value Value.
	 */
	public static function convertToJson( $value ) {
		if ( null === self::$convertObjectToJsonUseCase ) {
			self::$convertObjectToJsonUseCase = new ConvertObjectToJsonUseCase();
		}

		return self::$convertObjectToJsonUseCase->invoke( $value );
	}
}
