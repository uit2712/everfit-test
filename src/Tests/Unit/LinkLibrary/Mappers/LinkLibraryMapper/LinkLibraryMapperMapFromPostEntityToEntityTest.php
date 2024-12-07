<?php
namespace Tests\Unit\LinkLibrary\Mappers\LinkLibraryMapper;

use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\Post\Entities\PostEntity;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidObjectsForTestingTrait;
use Core\Traits\ListInvalidStringsForTestingTrait;
use Framework\Features\PostMeta\Facades\PostMeta;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LinkLibraryMapperMapFromPostEntityToEntityTest extends TestCase {
	use ListInvalidObjectsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;
	use ListInvalidStringsForTestingTrait;

	#[DataProvider( 'getListInvalidObjects' )]
	public function testInvalidData( $data ) {
		$actualResult = LinkLibrary::getMapper()->mapFromPostEntityToEntity( $data );

		$this->assertNull( $actualResult );
	}

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidId( $id ) {
		$data = new PostEntity();
		$data->id = $id;

		$actualResult = LinkLibrary::getMapper()->mapFromPostEntityToEntity( $data );

		$this->assertNull( $actualResult );
	}

	#[DataProvider( 'getListInvalidStrings' )]
	public function testInvalidTitle( $title ) {
		$data = new PostEntity();
		$data->id = 10;
		$data->title = $title;

		$actualResult = LinkLibrary::getMapper()->mapFromPostEntityToEntity( $data );
		$this->assertNull( $actualResult );
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
			array( $data1, $postMeta1, $postMetaAsInteger1, $expectedResult1 ),
		);
	}

	#[DataProvider( 'getListValidData' )]
	public function testSuccess( $data, $postMeta, $postMetaAsInteger, $expectedResult ) {
		$mockedPostMeta = $this->getMockBuilder( PostMeta::class )->getMock();
		$mockedPostMeta->method( 'getSingleValue' )->willReturnMap( $postMeta );
		$mockedPostMeta->method( 'getSingleValueAsInteger' )->willReturnMap( $postMetaAsInteger );

		LinkLibrary::getMapper()->setPostMeta( $mockedPostMeta );
		$actualResult = LinkLibrary::getMapper()->mapFromPostEntityToEntity( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
