<?php
namespace Tests\Unit\LinkLibrary\Mappers\CachedLinkLibraryMapper;

use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Traits\ListInvalidObjectsForTestingTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CachedLinkLibraryMapperMapFromCacheToEntityTest extends TestCase {
	use ListInvalidObjectsForTestingTrait;

	public static function getListInvalidData() {

		return array_merge(
			self::getListInvalidObjects(),
			array(
				array(
					JsonConverterApi::convertToJson(
						array(
							'id' => null,
						)
					)->data,
				),
				array(
					JsonConverterApi::convertToJson(
						array(
							'id' => '   ',
						)
					)->data,
				),
				array(
					JsonConverterApi::convertToJson(
						array(
							'id' => 1,
							'title' => null,
						)
					)->data,
				),
				array(
					JsonConverterApi::convertToJson(
						array(
							'id' => 1,
							'title' => '',
						)
					)->data,
				),
				array(
					JsonConverterApi::convertToJson(
						array(
							'id' => 1,
							'title' => '    ',
						)
					)->data,
				),
			)
		);
	}

	#[DataProvider( 'getListInvalidData' )]
	public function testInvalidData( $data ) {
		$actualResult = LinkLibrary::getCachedMapper()->mapFromCacheToEntity( $data );

		$this->assertNull( $actualResult );
	}

	public static function getListValidData() {
		$data1 = JsonConverterApi::convertToJson(
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
		$expectedResult1 = new LinkLibraryPostEntity();
		$expectedResult1->id = 1;
		$expectedResult1->title = 'title_1';
		$expectedResult1->createdDate = 'created_date_1';
		$expectedResult1->url = 'url_1';
		$expectedResult1->largeDescription = 'largeDescription_1';
		$expectedResult1->image = 'image_1';
		$expectedResult1->price = 1000;
		$expectedResult1->priceCurrency = 'VND';
		$expectedResult1->description = 'description_1';
		$expectedResult1->email = 'email_1';
		$expectedResult1->phone = 'phone_1';
		$expectedResult1->notes = 'notes_1';

		$data2 = JsonConverterApi::convertToJson(
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
		$expectedResult2 = new LinkLibraryPostEntity();
		$expectedResult2->id = 2;
		$expectedResult2->title = 'title_2';
		$expectedResult2->createdDate = 'created_date_2';
		$expectedResult2->url = 'url_2';
		$expectedResult2->largeDescription = 'largeDescription_2';
		$expectedResult2->image = 'image_2';
		$expectedResult2->price = 2000;
		$expectedResult2->priceCurrency = 'USD';
		$expectedResult2->description = 'description_2';
		$expectedResult2->email = 'email_2';
		$expectedResult2->phone = 'phone_2';
		$expectedResult2->notes = 'notes_2';

		return array(
			array( $data1, $expectedResult1 ),
			array( $data2, $expectedResult2 ),
		);
	}

	#[DataProvider( 'getListValidData' )]
	public function testSuccess( $data, $expectedResult ) {
		$actualResult = LinkLibrary::getCachedMapper()->mapFromCacheToEntity( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
