<?php

namespace Tests\Integration\JsonConverter;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\Result;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DecodeStringToJsonUseCaseTest extends TestCase {
	public static function getListNullOrEmptyValues(): array {
		return array(
			array( null ),
			array( '' ),
			array( '      ' ),
		);
	}

	/**
	 * @param string|null $value Value.
	 */
	#[DataProvider( 'getListNullOrEmptyValues' )]
	public function testReturnsNullOrEmptyValue( $value ): void {
		$expectResult = new Result();
		$expectResult->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'value' );
		$expectResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = JsonConverterApi::decode( $value );

		$this->assertEquals( $expectResult, $actualResult );
	}

	public static function getListInvalidValues(): array {
		return array(
			array( '{""}' ),
			array( '{"test": 123} 456' ),
		);
	}

	/**
	 * @param string|null $value Value.
	 */
	#[DataProvider( 'getListInvalidValues' )]
	public function testCanNotDecodeString( $value ): void {
		$expectResult = new Result();
		$expectResult->message = sprintf( JsonConverterErrorMessage::CAN_NOT_DECODE_STRING );
		$expectResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = JsonConverterApi::decode( $value );

		$this->assertEquals( $expectResult, $actualResult );
	}

	public static function getListValidValues(): array {
		return array(
			array( '{}' ),
			array( '{"test": 123}' ),
		);
	}

	/**
	 * @param string|null $value Value.
	 */
	#[DataProvider( 'getListValidValues' )]
	public function testDecodeStringSuccess( $value ): void {
		$expectResult = new Result();
		$expectResult->success = true;
		$expectResult->message = sprintf( JsonConverterSuccessMessage::DECODE_STRING_TO_JSON_SUCCESS );
		$expectResult->data = json_decode( $value );

		$actualResult = JsonConverterApi::decode( $value );

		$this->assertEquals( $expectResult, $actualResult );
	}
}
