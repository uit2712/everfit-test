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

class ConvertObjectToJsonUseCaseTest extends TestCase {

	public static function getListInvalidData() {
		return array(
			array( null ),
		);
	}

	#[DataProvider( 'getListInvalidData' )]
	public function testInvalidData( $value ) {
		$expectedResult = new Result();
		$expectedResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'value' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = JsonConverterApi::convertToJson( $value );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public static function getListValidData() {
		$data1 = 1;
		$expectedData1 = 1;

		$data2 = '1';
		$expectedData2 = 1;

		$data3 = '{}';
		$expectedData3 = '{}';

		$data4 = array();
		$expectedData4 = array();

		$data5 = array(
			'a' => 1,
			'b' => 2,
		);
		$expectedData5 = new stdClass();
		$expectedData5->a = 1;
		$expectedData5->b = 2;

		$data6 = $expectedData5;
		$data6->b = '2';
		$expectedData6 = new stdClass();
		$expectedData6->a = 1;
		$expectedData6->b = '2';

		return array(
			array( $data1, $expectedData1 ),
			array( $data2, $expectedData2 ),
			array( $data3, $expectedData3 ),
			array( $data4, $expectedData4 ),
			array( $data5, $expectedData5 ),
			array( $data6, $expectedData6 ),
		);
	}

	#[DataProvider( 'getListValidData' )]
	public function testValidData( $data, $expectedData ) {
		$expectedResult = new Result();
		$expectedResult->success = true;
		$expectedResult->message = sprintf( JsonConverterSuccessMessage::CONVERT_OBJECT_TO_JSON_SUCCESS );
		$expectedResult->data = $expectedData;

		$actualResult = JsonConverterApi::convertToJson( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
