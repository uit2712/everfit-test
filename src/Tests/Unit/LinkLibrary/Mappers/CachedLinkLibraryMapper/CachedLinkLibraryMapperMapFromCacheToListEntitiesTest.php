<?php
namespace Tests\Unit\LinkLibrary\Mappers\CachedLinkLibraryMapper;

use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Traits\ListInvalidOrEmptyArrayForTestingTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CachedLinkLibraryMapperMapFromCacheToListEntitiesTest extends TestCase {
	use ListInvalidOrEmptyArrayForTestingTrait;

	public static function getListInvalidData() {

		return array_merge(
			self::getListInvalidOrEmptyArrays(),
			array(
				array(
					array(
						JsonConverterApi::convertToJson(
							array(
								'id' => null,
							)
						)->data,
						JsonConverterApi::convertToJson(
							array(
								'id' => '   ',
							)
						)->data,
						JsonConverterApi::convertToJson(
							array(
								'id' => 1,
								'title' => null,
							)
						)->data,
						JsonConverterApi::convertToJson(
							array(
								'id' => 1,
								'title' => '',
							)
						)->data,
						JsonConverterApi::convertToJson(
							array(
								'id' => 1,
								'title' => '    ',
							)
						)->data,
					),
				),
			)
		);
	}

	#[DataProvider( 'getListInvalidData' )]
	public function testInvalidData( $data ) {
		$actualResult = LinkLibrary::getCachedMapper()->mapFromCacheToListEntities( $data );

		$this->assertEquals( array(), $actualResult );
	}

	public static function getListValidData() {
		$dataItem1 = JsonConverterApi::convertToJson(
			array(
				'id' => 1,
				'title' => '  title_1   ',
				'createdDate' => '  created_date_1   ',
				'url' => '  url_1   ',
				'largeDescription' => '  largeDescription_1   ',
				'image' => '  image_1   ',
				'price' => 1000,
				'priceCurrency' => '  VND  ',
				'description' => 'description_1   ',
				'email' => 'email_1   ',
				'phone' => 'phone_1   ',
				'notes' => ' notes_1',
			)
		)->data;
		$expectedDataItem1 = new LinkLibraryPostEntity();
		$expectedDataItem1->id = 1;
		$expectedDataItem1->title = 'title_1';
		$expectedDataItem1->createdDate = 'created_date_1';
		$expectedDataItem1->url = 'url_1';
		$expectedDataItem1->largeDescription = 'largeDescription_1';
		$expectedDataItem1->image = 'image_1';
		$expectedDataItem1->price = 1000;
		$expectedDataItem1->priceCurrency = 'VND';
		$expectedDataItem1->description = 'description_1';
		$expectedDataItem1->email = 'email_1';
		$expectedDataItem1->phone = 'phone_1';
		$expectedDataItem1->notes = 'notes_1';

		$dataItem2 = JsonConverterApi::convertToJson(
			array(
				'id' => 2,
				'title' => '  title_2   ',
				'createdDate' => '  created_date_2   ',
				'url' => '  url_2   ',
				'largeDescription' => '  largeDescription_2   ',
				'image' => '  image_2   ',
				'price' => 2000,
				'priceCurrency' => '  USD  ',
				'description' => 'description_2   ',
				'email' => 'email_2   ',
				'phone' => 'phone_2   ',
				'notes' => ' notes_2',
			)
		)->data;
		$expectedDataItem2 = new LinkLibraryPostEntity();
		$expectedDataItem2->id = 2;
		$expectedDataItem2->title = 'title_2';
		$expectedDataItem2->createdDate = 'created_date_2';
		$expectedDataItem2->url = 'url_2';
		$expectedDataItem2->largeDescription = 'largeDescription_2';
		$expectedDataItem2->image = 'image_2';
		$expectedDataItem2->price = 2000;
		$expectedDataItem2->priceCurrency = 'USD';
		$expectedDataItem2->description = 'description_2';
		$expectedDataItem2->email = 'email_2';
		$expectedDataItem2->phone = 'phone_2';
		$expectedDataItem2->notes = 'notes_2';

		return array(
			array( array( $dataItem1, null ), array( $expectedDataItem1 ) ),
			array( array( $dataItem2, null ), array( $expectedDataItem2 ) ),
			array( array( $dataItem1, $dataItem2 ), array( $expectedDataItem1, $expectedDataItem2 ) ),
		);
	}

	#[DataProvider( 'getListValidData' )]
	public function testSuccess( $data, $expectedResult ) {
		$actualResult = LinkLibrary::getCachedMapper()->mapFromCacheToListEntities( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
