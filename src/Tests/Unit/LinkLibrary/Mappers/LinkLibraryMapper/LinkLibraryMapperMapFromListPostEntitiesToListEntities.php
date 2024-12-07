<?php
namespace Tests\Unit\LinkLibrary\Mappers\LinkLibraryMapper;

use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\Post\Entities\PostEntity;
use Core\Traits\ListInvalidOrEmptyArrayForTestingTrait;
use Framework\Features\PostMeta\Facades\PostMeta;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class LinkLibraryMapperMapFromListPostEntitiesToListEntities extends TestCase {
	use ListInvalidOrEmptyArrayForTestingTrait;

	public static function getListInvalidData() {
		$data1 = new stdClass();

		$data2 = new PostEntity();

		$data3 = new PostEntity();
		$data3->id = -1;

		$data4 = new PostEntity();
		$data4->id = 1;
		$data4->title = '';

		$data4 = new PostEntity();
		$data4->id = 1;
		$data4->title = '    ';

		return array_merge(
			self::getListInvalidOrEmptyArrays(),
			array(
				array(
					$data1,
					$data2,
					$data3,
					$data4,
				),
			)
		);
	}

	#[DataProvider( 'getListInvalidData' )]
	public function testInvalidData( $data ) {
		$actualResult = LinkLibrary::getMapper()->mapFromListPostEntitiesToListEntities( $data );

		$this->assertEquals( array(), $actualResult );
	}

	public static function getListValidData() {
		$data1 = new PostEntity();
		$data1->id = 1;
		$data1->title = '   title_1   ';

		$postMeta1 = array(
			array( $data1->id, LinkLibraryConstants::IMAGE_META_KEY, '   https://image.com/image.png' ),
			array( $data1->id, LinkLibraryConstants::PRICE_META_KEY, '111' ),
			array( $data1->id, LinkLibraryConstants::DESCRIPTION_META_KEY, '    description_1' ),
			array( $data1->id, LinkLibraryConstants::LARGE_DESCRIPTION_META_KEY, 'large_description_1    ' ),
			array( $data1->id, LinkLibraryConstants::EMAIL_META_KEY, 'email_1' ),
			array( $data1->id, LinkLibraryConstants::TELEPHONE_META_KEY, '   ' ),
			array( $data1->id, LinkLibraryConstants::NOTES_META_KEY, '    notes_1  ' ),
			array( $data1->id, LinkLibraryConstants::URL_META_KEY, '   url_1 ' ),
		);

		$postMetaAsInteger1 = array(
			array( $data1->id, LinkLibraryConstants::PRICE_META_KEY, 111 ),
		);

		$expectedResult1 = new LinkLibraryPostEntity();
		$expectedResult1->id = 1;
		$expectedResult1->title = 'title_1';
		$expectedResult1->image = 'https://image.com/image.png';
		$expectedResult1->price = 111;
		$expectedResult1->description = 'description_1';
		$expectedResult1->largeDescription = 'large_description_1';
		$expectedResult1->email = '';
		$expectedResult1->phone = '';
		$expectedResult1->notes = 'notes_1';
		$expectedResult1->url = 'url_1';

		return array(
			array( array( $data1, null ), $postMeta1, $postMetaAsInteger1, array( $expectedResult1 ) ),
		);
	}

	#[DataProvider( 'getListValidData' )]
	public function testSuccess( $data, $postMeta, $postMetaAsInteger, $expectedResult ) {
		$mockedPostMeta = $this->getMockBuilder( PostMeta::class )->getMock();
		$mockedPostMeta->method( 'getSingleValue' )->willReturnMap( $postMeta );
		$mockedPostMeta->method( 'getSingleValueAsInteger' )->willReturnMap( $postMetaAsInteger );

		LinkLibrary::getMapper()->setPostMeta( $mockedPostMeta );
		$actualResult = LinkLibrary::getMapper()->mapFromListPostEntitiesToListEntities( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
