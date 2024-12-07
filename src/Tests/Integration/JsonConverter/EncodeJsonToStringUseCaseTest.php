<?php

namespace Tests\Integration\JsonConverter;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\Result;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class EncodeJsonToStringUseCaseTest extends TestCase {
	public static function getListInvalidValues(): array {
		return array(
			array( null ),
			array( false ),
			array( true ),
		);
	}

	/**
	 * @param mixed|null $value Value.
	 */
	#[DataProvider( 'getListInvalidValues' )]
	public function testInvalidInputValues( $value ): void {
		$expectResult = new Result();
		$expectResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'value' );
		$expectResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = JsonConverterApi::encode( $value );

		$this->assertEquals( $expectResult, $actualResult );
	}

	public static function getListValidValues(): array {
		$value1 = new stdClass();
		$expected1 = '{}';

		$value2 = new stdClass();
		$value2->test = 123;
		$expected2 = '{"test":123}';

		$value3 = new stdClass();
		$value3->first = 456;
		$value3->second = 'abc';
		$expected3 = '{"first":456,"second":"abc"}';

		return array(
			array( $value1, $expected1 ),
			array( $value2, $expected2 ),
			array( $value3, $expected3 ),
		);
	}

	/**
	 * @param mixed|null $value Value.
	 * @param string     $expectedValue Expected value.
	 */
	#[DataProvider( 'getListValidValues' )]
	public function testDecodeStringSuccess( $value, $expectedValue ): void {
		$expectResult = new Result();
		$expectResult->success = true;
		$expectResult->message = sprintf( JsonConverterSuccessMessage::ENCODE_JSON_TO_STRING_SUCCESS );
		$expectResult->data = $expectedValue;

		$actualResult = JsonConverterApi::encode( $value );

		$this->assertEquals( $expectResult, $actualResult );
	}
}
