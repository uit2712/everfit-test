<?php

namespace Tests\Integration\JsonConverter;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\ArrayResult;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class ConvertJsonToArrayUseCaseTest extends TestCase {
	public static function getListInvalidValues(): array {
		return array(
			array( null, array() ),
			array( false, array() ),
		);
	}

	/**
	 * @param mixed $input Input.
	 * @param array $expectedValue Expected value.
	 */
	#[DataProvider( 'getListInvalidValues' )]
	public function testInvalidInputValues( $input, $expectedValue ): void {
		$expectResult = new ArrayResult();
		$expectResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'value' );
		$expectResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
		$expectResult->data = $expectedValue;

		$actualResult = JsonConverterApi::convertToArray( $input );

		$this->assertEquals( $expectResult, $actualResult );
	}

	public static function getListValidValues(): array {
		$input1 = new stdClass();
		$expectedValue1 = array();

		$input2 = new stdClass();
		$input2->test = 123;
		$expectedValue2 = array( 'test' => 123 );

		$input3 = new stdClass();
		$input3->first = 456;
		$input3->second = 'abc';
		$expectedValue3 = array(
			'first' => 456,
			'second' => 'abc',
		);

		$input4 = array( $input2, $input3 );
		$expectedValue4 = array( $expectedValue2, $expectedValue3 );

		return array(
			array( $input1, $expectedValue1 ),
			array( $input2, $expectedValue2 ),
			array( $input3, $expectedValue3 ),
			array( $input4, $expectedValue4 ),
		);
	}

	/**
	 * @param mixed|null $value Value.
	 * @param array      $expectedValue Expected value.
	 */
	#[DataProvider( 'getListValidValues' )]
	public function testConvertJsonToArraySuccess( $value, $expectedValue ): void {
		$expectResult = new ArrayResult();
		$expectResult->success = true;
		$expectResult->message = sprintf( JsonConverterSuccessMessage::CONVERT_JSON_TO_ARRAY_SUCCESS );
		$expectResult->data = $expectedValue;

		$actualResult = JsonConverterApi::convertToArray( $value );

		$this->assertEquals( $expectResult, $actualResult );
	}
}
