<?php
namespace Tests\Integration\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\Cache\Traits\MockedCacheForTestingTrait;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Models\GetLibraryLinkResult;
use Core\Features\LinkLibrary\Traits\MockedGetLibraryLinkByIdUseCaseForTestingTrait;
use Core\Features\LinkLibrary\UseCases\GetLibraryLinkByIdFromCacheUseCase;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidModelsForTestingTrait;
use Core\ViewModels\GetItemByIntegerIdViewModel;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetLibraryLinkByIdFromCacheUseCaseTest extends TestCase {
	use ListInvalidModelsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;
	use MockedGetLibraryLinkByIdUseCaseForTestingTrait;
	use MockedCacheForTestingTrait;

	#[DataProvider( 'getListInvalidModels' )]
	public function testInvalidModel( $model ) {
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'model' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$useCase = new GetLibraryLinkByIdFromCacheUseCase();
		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidId( $id ) {
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'id' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => $id,
			)
		);

		$useCase = new GetLibraryLinkByIdFromCacheUseCase();
		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundInBothCacheAndDatabase() {
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$expectedResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => '10',
			)
		);

		$mockedCache = $this->getMockedCache();
		$mockedCache->method( 'get' )->willReturn( null );

		$mockedGetLinkResult = new GetLibraryLinkResult();
		$mockedGetLinkResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$mockedGetLinkResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
		$mockedGetLibraryLinkByIdUseCase = $this->getMockedGetLibraryLinkByIdUseCaseInstance();
		$mockedGetLibraryLinkByIdUseCase->method( 'invoke' )->willReturn( $mockedGetLinkResult );

		$useCase = new GetLibraryLinkByIdFromCacheUseCase();
		$useCase->setGetLibraryLinkByIdUseCaseInstance( $mockedGetLibraryLinkByIdUseCase );
		$useCase->setCache( $mockedCache );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundInCacheButInDatabaseAndStoreIntoCacheFailed() {
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->message = sprintf( ErrorMessage::STORE_DATA_TO_CACHE_FAILED );

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => '10',
			)
		);

		$mockedCache = $this->getMockedCache();
		$mockedCache->method( 'get' )->willReturn( null );
		$mockedCache->method( 'setMultiple' )->willReturn( false );

		$mockedLink = new LinkLibraryPostEntity();
		$mockedLink->id = 1;
		$mockedLink->title = 'title';
		$mockedLink->description = 'description';
		$mockedGetLinkResult = new GetLibraryLinkResult();
		$mockedGetLinkResult->success = true;
		$mockedGetLinkResult->data = $mockedLink;
		$mockedGetLibraryLinkByIdUseCase = $this->getMockedGetLibraryLinkByIdUseCaseInstance();
		$mockedGetLibraryLinkByIdUseCase->method( 'invoke' )->willReturn( $mockedGetLinkResult );

		$useCase = new GetLibraryLinkByIdFromCacheUseCase();
		$useCase->setGetLibraryLinkByIdUseCaseInstance( $mockedGetLibraryLinkByIdUseCase );
		$useCase->setCache( $mockedCache );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundInCacheButInDatabaseAndStoreIntoCacheSuccess() {
		$expectedData = new LinkLibraryPostEntity();
		$expectedData->id = 1;
		$expectedData->title = 'title';
		$expectedData->description = 'description';
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->success = true;
		$expectedResult->data = $expectedData;

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => '10',
			)
		);

		$mockedCache = $this->getMockedCache();
		$mockedCache->method( 'get' )->willReturn( null );
		$mockedCache->method( 'setMultiple' )->willReturn( true );

		$mockedGetLinkResult = new GetLibraryLinkResult();
		$mockedGetLinkResult->success = true;
		$mockedGetLinkResult->data = $expectedData;
		$mockedGetLibraryLinkByIdUseCase = $this->getMockedGetLibraryLinkByIdUseCaseInstance();
		$mockedGetLibraryLinkByIdUseCase->method( 'invoke' )->willReturn( $mockedGetLinkResult );

		$useCase = new GetLibraryLinkByIdFromCacheUseCase();
		$useCase->setGetLibraryLinkByIdUseCaseInstance( $mockedGetLibraryLinkByIdUseCase );
		$useCase->setCache( $mockedCache );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testFoundInCache() {
		$expectedData = new LinkLibraryPostEntity();
		$expectedData->id = 1;
		$expectedData->title = 'title';
		$expectedData->description = 'description';
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->success = true;
		$expectedResult->message = sprintf( LinkLibraryConstants::GET_LINK_BY_ID_FROM_CACHE_SUCCESS_MESSAGE );
		$expectedResult->data = $expectedData;

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => '10',
			)
		);

		$mockedCache = $this->getMockedCache();
		$mockedDataFromCacheResult = JsonConverterApi::convertToJson(
			array(
				'id' => 1,
				'title' => 'title',
				'description' => 'description',
			)
		)->data;
		$mockedCache->method( 'get' )->willReturn( $mockedDataFromCacheResult );

		$useCase = new GetLibraryLinkByIdFromCacheUseCase();
		$useCase->setCache( $mockedCache );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
