<?php
namespace Tests\Unit\LinkLibrary\Mappers\CachedLinkLibraryMapper;

use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Traits\ListInvalidObjectsForTestingTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class CachedLinkLibraryMapperMapFromEntityToCacheItemTest extends TestCase {
	use ListInvalidObjectsForTestingTrait;

	public static function getListInvalidData() {
		return array_merge(
			self::getListInvalidObjects(),
			array(
				array( new stdClass() ),
				array( new LinkLibraryPostEntity() ),
			)
		);
	}

	#[DataProvider( 'getListInvalidData' )]
	public function testInvalidData( $data ) {
		$expectedResult = array();

		$actualResult = LinkLibrary::getCachedMapper()->mapFromEntityToCacheItem( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public static function getListValidData() {
		$item1 = new LinkLibraryPostEntity();
		$item1->id = 'id_1';
		$item1->title = 'title_1';
		$item1->description = 'description_1';
		$item1->url = 'url_1';
		$item1->image = 'image_1';

		$item2 = new LinkLibraryPostEntity();
		$item2->id = 'id_2';
		$item2->title = 'title_2';
		$item2->description = 'description_2';
		$item2->url = 'url_2';
		$item2->image = 'image_2';

		return array(
			array( $item1, array( sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $item1->id ) => $item1 ) ),
			array( $item2, array( sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $item2->id ) => $item2 ) ),
		);
	}

	#[DataProvider( 'getListValidData' )]
	public function testSuccess( $data, $expectedResult ) {
		$actualResult = LinkLibrary::getCachedMapper()->mapFromEntityToCacheItem( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
