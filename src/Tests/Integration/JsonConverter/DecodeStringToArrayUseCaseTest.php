<?php

namespace Tests\Integration\JsonConverter;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\ArrayResult;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DecodeStringToArrayUseCaseTest extends TestCase {
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
		$expectResult = new ArrayResult();
		$expectResult->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'value' );
		$expectResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = JsonConverterApi::decodeAsArray( $value );

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
		$expectResult = new ArrayResult();
		$expectResult->message = sprintf( JsonConverterErrorMessage::CAN_NOT_DECODE_STRING );
		$expectResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = JsonConverterApi::decodeAsArray( $value );

		$this->assertEquals( $expectResult, $actualResult );
	}

	public static function getListValidValues(): array {
		$input1 = '{}';
		$expectedValue1 = array();

		$input2 = '{"test": 123}';
		$expectedValue2 = array( 'test' => 123 );

		$input3 = '{"test": 123, "test3": "hello"}';
		$expectedValue3 = array(
			'test' => 123,
			'test3' => 'hello',
		);

		$input4 = '[1, "456", 4444, null]';
		$expectedValue4 = array( 1, '456', 4444, null );

		return array(
			array( $input1, $expectedValue1 ),
			array( $input2, $expectedValue2 ),
			array( $input3, $expectedValue3 ),
			array( $input4, $expectedValue4 ),
		);
	}

	/**
	 * @param string|null $input Input.
	 * @param array|null  $expectedValue Expected value.
	 */
	#[DataProvider( 'getListValidValues' )]
	public function testDecodeStringSuccess( $input, $expectedValue ): void {
		$expectResult = new ArrayResult();
		$expectResult->success = true;
		$expectResult->message = sprintf( JsonConverterSuccessMessage::DECODE_STRING_TO_ARRAY_SUCCESS );
		$expectResult->data = $expectedValue;

		$actualResult = JsonConverterApi::decodeAsArray( $input );

		$this->assertEquals( $expectResult, $actualResult );
	}
}
