<?php
namespace Tests\Integration\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\Cache\Traits\MockedCacheForTestingTrait;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryRepositoryInterface;
use Core\Features\LinkLibrary\Models\GetLibraryLinkResult;
use Core\Features\LinkLibrary\Models\GetListLibraryLinksResult;
use Core\Features\LinkLibrary\UseCases\GetLibraryLinkByIdFromCacheUseCase;
use Core\Features\LinkLibrary\UseCases\GetListLibraryLinksBySlugFromCacheUseCase;
use Core\Features\LinkLibrary\UseCases\GetListLibraryLinksBySlugUseCase;
use Core\Features\LinkLibrary\ViewModels\GetListLibraryLinksBySlugViewModel;
use Core\Helpers\ArrayHelper;
use Core\Models\ArrayResult;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidModelsForTestingTrait;
use Core\Traits\ListInvalidStringsForTestingTrait;
use Core\ViewModels\GetItemByIntegerIdViewModel;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetListLibraryLinksBySlugFromCacheUseCaseTest extends TestCase {
	use ListInvalidModelsForTestingTrait;
	use ListInvalidStringsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;
	use MockedCacheForTestingTrait;

	#[DataProvider( 'getListInvalidModels' )]
	public function testInvalidModel( $model ) {
		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'model' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	#[DataProvider( 'getListInvalidStrings' )]
	public function testInvalidSlug( $slug ) {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => $slug,
			)
		);

		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'slug' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidTotal( $total ) {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => $total,
			)
		);

		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'total' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundAnyItemsInCacheAndDatabase() {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => 10,
			)
		);

		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$expectedResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;

		$keyCache = sprintf(
			LinkLibraryConstants::GET_LIST_LINKS_BY_SLUG_KEY_CACHE,
			$model->slug,
			$model->total
		);
		$mockedGetListIdsInCacheResult = array();
		$defaultListIds = array();
		$mockedCache = $this->getMockedCache();
		$mockedCache->method( 'get' )->willReturnMap(
			array(
				array(
					$keyCache,
					$defaultListIds,
					$mockedGetListIdsInCacheResult,
				),
			)
		);

		$mockedGetLinksResult = new ArrayResult();
		$mockedGetLinksResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$mockedGetLinksResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
		$mockedGetListLibraryLinksBySlugUseCase =
			$this->getMockBuilder( GetListLibraryLinksBySlugUseCase::class )
				->getMock();
		$mockedGetListLibraryLinksBySlugUseCase->method( 'invoke' )->willReturn( $mockedGetLinksResult );

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();
		$useCase->setCache( $mockedCache );
		$useCase->setGetListLibraryLinksBySlugUseCaseInstance( $mockedGetListLibraryLinksBySlugUseCase );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundAnyItemsInCacheButFoundInDatabaseAndSaveIntoCacheFailed() {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => 10,
			)
		);

		$expectedDataItem1 = new LinkLibraryPostEntity();
		$expectedDataItem1->id = 1;
		$expectedDataItem1->title = 'post_title';
		$expectedDataItem1->description = 'description';
		$expectedDataItem1->url = 'url';

		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->message = sprintf( ErrorMessage::STORE_DATA_TO_CACHE_FAILED );

		$keyCache = sprintf(
			LinkLibraryConstants::GET_LIST_LINKS_BY_SLUG_KEY_CACHE,
			$model->slug,
			$model->total
		);
		$mockedCache = $this->getMockedCache();

		$mockedGetListIdsInCacheResult = array();
		$defaultListIds = array();
		$mockedCache->method( 'get' )->willReturnMap(
			array(
				array(
					$keyCache,
					$defaultListIds,
					$mockedGetListIdsInCacheResult,
				),
			)
		);

		$mockedGetLinksResult = new GetListLibraryLinksResult();
		$mockedGetLinksResult->success = true;
		$mockedGetLinksResult->data = array( $expectedDataItem1 );
		$mockedGetListLibraryLinksBySlugUseCase =
			$this->getMockBuilder( GetListLibraryLinksBySlugUseCase::class )
				->getMock();
		$mockedGetListLibraryLinksBySlugUseCase->method( 'invoke' )->willReturn( $mockedGetLinksResult );

		$mockedSaveDataToCacheResult = false;
		$mockedCache->method( 'setMultiple' )->willReturn( $mockedSaveDataToCacheResult );

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();
		$useCase->setCache( $mockedCache );
		$useCase->setGetListLibraryLinksBySlugUseCaseInstance( $mockedGetListLibraryLinksBySlugUseCase );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundAnyItemsInCacheButFoundInDatabaseAndSaveIntoCacheSuccess() {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => 10,
			)
		);

		$expectedDataItem1 = new LinkLibraryPostEntity();
		$expectedDataItem1->id = 1;
		$expectedDataItem1->title = 'post_title';
		$expectedDataItem1->description = 'description';
		$expectedDataItem1->url = 'url';

		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->success = true;
		$expectedResult->data = array( $expectedDataItem1 );

		$keyCache = sprintf(
			LinkLibraryConstants::GET_LIST_LINKS_BY_SLUG_KEY_CACHE,
			$model->slug,
			$model->total
		);
		$mockedCache = $this->getMockedCache();

		$mockedGetListIdsInCacheResult = array();
		$defaultListIds = array();
		$mockedCache->method( 'get' )->willReturnMap(
			array(
				array(
					$keyCache,
					$defaultListIds,
					$mockedGetListIdsInCacheResult,
				),
			)
		);

		$mockedGetLinksResult = new GetListLibraryLinksResult();
		$mockedGetLinksResult->success = true;
		$mockedGetLinksResult->data = array( $expectedDataItem1 );
		$mockedGetListLibraryLinksBySlugUseCase =
			$this->getMockBuilder( GetListLibraryLinksBySlugUseCase::class )
				->getMock();
		$mockedGetListLibraryLinksBySlugUseCase->method( 'invoke' )->willReturn( $mockedGetLinksResult );

		$mockedSaveDataToCacheResult = true;
		$mockedCache->method( 'setMultiple' )->willReturn( $mockedSaveDataToCacheResult );

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();
		$useCase->setCache( $mockedCache );
		$useCase->setGetListLibraryLinksBySlugUseCaseInstance( $mockedGetListLibraryLinksBySlugUseCase );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public static function getListFoundAllItemsInCache() {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => 10,
			)
		);

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

		$keyCache = sprintf(
			LinkLibraryConstants::GET_LIST_LINKS_BY_SLUG_KEY_CACHE,
			$model->slug,
			$model->total
		);

		return array(
			array(
				$model,
				array( $expectedDataItem1 ),
				array(
					array(
						$keyCache,
						array(),
						array( $expectedDataItem1->id ),
					),
				),
				array(
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $expectedDataItem1->id ) => $dataItem1,
				),
			),
			array(
				$model,
				array( $expectedDataItem2 ),
				array(
					array(
						$keyCache,
						array(),
						array( $expectedDataItem2->id ),
					),
				),
				array(
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $expectedDataItem2->id ) => $dataItem2,
				),
			),
			array(
				$model,
				array( $expectedDataItem1, $expectedDataItem2 ),
				array(
					array(
						$keyCache,
						array(),
						array( $expectedDataItem1->id, $expectedDataItem2->id ),
					),
				),
				array(
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $expectedDataItem1->id ) => $dataItem1,
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $expectedDataItem2->id ) => $dataItem2,
				),
			),
		);
	}

	#[DataProvider( 'getListFoundAllItemsInCache' )]
	public function testFoundAllItemsInCache( $model, $expectedData, $mockedGetListIdsInCacheResult, $mockedGetMultipleInCacheResult ) {
		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->success = true;
		$expectedResult->message = sprintf( LinkLibraryConstants::GET_LINKS_BY_SLUG_FROM_CACHE_SUCCESS_MESSAGE );
		$expectedResult->data = $expectedData;

		$mockedCache = $this->getMockedCache();

		$mockedCache->method( 'get' )->willReturnMap( $mockedGetListIdsInCacheResult );
		$mockedCache->method( 'getMultipleKeepKeys' )->willReturn( $mockedGetMultipleInCacheResult );

		$mockedGetLinksResult = new GetListLibraryLinksResult();
		$mockedGetLinksResult->success = true;
		$mockedGetLinksResult->data = $expectedData;
		$mockedGetListLibraryLinksBySlugUseCase =
			$this->getMockBuilder( GetListLibraryLinksBySlugUseCase::class )
				->getMock();
		$mockedGetListLibraryLinksBySlugUseCase->method( 'invoke' )->willReturn( $mockedGetLinksResult );

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();
		$useCase->setCache( $mockedCache );
		$useCase->setGetListLibraryLinksBySlugUseCaseInstance( $mockedGetListLibraryLinksBySlugUseCase );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public static function getListFoundMostItemsInCacheButNotAll() {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => 10,
			)
		);

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

		$keyCache = sprintf(
			LinkLibraryConstants::GET_LIST_LINKS_BY_SLUG_KEY_CACHE,
			$model->slug,
			$model->total
		);

		return array(
			array(
				$model,
				array( $expectedDataItem1, $expectedDataItem2 ),
				array(
					array(
						$keyCache,
						array(),
						array( $expectedDataItem1->id, $expectedDataItem2->id ),
					),
				),
				array(
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $expectedDataItem1->id ) => $dataItem1,
					sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $expectedDataItem2->id ) => null,
				),
				function ( GetItemByIntegerIdViewModel $model ) use ( $expectedDataItem2 ) {
					$result = new GetLibraryLinkResult();

					if ( 2 === $model->id ) {
						$result->success = true;
						$result->data = $expectedDataItem2;
						return $result;
					}

					return null;
				},
			),
		);
	}

	#[DataProvider( 'getListFoundMostItemsInCacheButNotAll' )]
	public function testFoundMostItemsInCacheButNotAll(
		$model,
		$expectedData,
		$mockedGetListIdsInCacheResult,
		$mockedGetMultipleInCacheResult,
		$mockedGetDataInDatabaseCallback
	) {
		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->success = true;
		$expectedResult->message = sprintf( LinkLibraryConstants::GET_LINKS_BY_SLUG_FROM_CACHE_SUCCESS_MESSAGE );
		$expectedResult->data = $expectedData;

		$mockedCache = $this->getMockedCache();

		$mockedCache->method( 'get' )->willReturnMap( $mockedGetListIdsInCacheResult );
		$mockedCache->method( 'getMultipleKeepKeys' )->willReturn( $mockedGetMultipleInCacheResult );

		$mockedGetLinksResult = new GetListLibraryLinksResult();
		$mockedGetLinksResult->success = true;
		$mockedGetLinksResult->data = $expectedData;
		$mockedGetListLibraryLinksBySlugUseCase =
			$this->getMockBuilder( GetListLibraryLinksBySlugUseCase::class )
				->getMock();
		$mockedGetListLibraryLinksBySlugUseCase->method( 'invoke' )->willReturn( $mockedGetLinksResult );

		$mockedGetLibraryLinkByIdFromCacheUseCase =
			$this->getMockBuilder( GetLibraryLinkByIdFromCacheUseCase::class )
				->getMock();
		$mockedGetLibraryLinkByIdFromCacheUseCase->method( 'invoke' )->willReturnCallback( $mockedGetDataInDatabaseCallback );

		$useCase = new GetListLibraryLinksBySlugFromCacheUseCase();
		$useCase->setCache( $mockedCache );
		$useCase->setGetListLibraryLinksBySlugUseCaseInstance( $mockedGetListLibraryLinksBySlugUseCase );
		$useCase->setGetLibraryLinkByIdFromCacheUseCaseInstance( $mockedGetLibraryLinkByIdFromCacheUseCase );

		$actualResult = $useCase->invoke( $model );
		// file_put_contents(
		// '/root/ykhoaphuongbac/debug.log',
		// json_encode(
		// $actualResult
		// )
		// );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
