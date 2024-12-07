<?php
namespace Tests\Unit\LinkLibrary\Mappers\CachedLinkLibraryMapper;

use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Traits\ListInvalidOrEmptyArrayForTestingTrait;
use Core\Traits\ListInvalidStringsForTestingTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class CachedLinkLibraryMapperMapFromListEntitiesToListCacheItemsTest extends TestCase {
	use ListInvalidOrEmptyArrayForTestingTrait;
	use ListInvalidStringsForTestingTrait;

	#[DataProvider( 'getListInvalidStrings' )]
	public function testInvalidParentKeyCache( $parentKeyCache ) {
		$expectedResult = array();

		$actualResult = LinkLibrary::getCachedMapper()->mapFromListEntitiesToListCacheItems( $parentKeyCache, null );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public static function getListInvalidData() {
		return array_merge(
			self::getListInvalidOrEmptyArrays(),
			array(
				array( array( new stdClass(), new LinkLibraryPostEntity() ) ),
			)
		);
	}

	#[DataProvider( 'getListInvalidData' )]
	public function testInvalidData( $data ) {
		$expectedResult = array();

		$actualResult = LinkLibrary::getCachedMapper()->mapFromListEntitiesToListCacheItems( 'parentKeyCache', $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public static function getListValidData() {
		$item1 = new LinkLibraryPostEntity();
		$item1->id = 1;
		$item1->title = 'title_1';
		$item1->description = 'description_1';
		$item1->url = 'url_1';
		$item1->image = 'image_1';

		$item2 = new LinkLibraryPostEntity();
		$item2->id = 2;
		$item2->title = 'title_2';
		$item2->description = 'description_2';
		$item2->url = 'url_2';
		$item2->image = 'image_2';

		return array(
			array(
				array( $item1 ),
				array( sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $item1->id ) => $item1 ),
			),
			array(
				array( $item2 ),
				array( sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $item2->id ) => $item2 ),
			),
			array(
				array( $item1, $item2 ),
				array(
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $item1->id ) => $item1,
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $item2->id ) => $item2,
				),
			),
		);
	}

	/**
	 * @param LinkLibraryPostEntity[] $data Data.
	 * @param array                   $expectedResult Expected result.
	 */
	#[DataProvider( 'getListValidData' )]
	public function testSuccess( $data, $expectedResult ) {
		$parentKeyCache = 'parentKeyCache';
		$expectedResult = array_merge(
			array(
				$parentKeyCache => array_map(
					function ( $data ) {
						return $data->id;
					},
					$data,
				),
			),
			$expectedResult,
		);

		$actualResult = LinkLibrary::getCachedMapper()->mapFromListEntitiesToListCacheItems( $parentKeyCache, $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
