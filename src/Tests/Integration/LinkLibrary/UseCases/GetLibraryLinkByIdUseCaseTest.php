<?php
namespace Tests\Integration\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\LinkLibrary\Models\GetLibraryLinkResult;
use Core\Features\LinkLibrary\UseCases\GetLibraryLinkByIdUseCase;
use Core\Features\Post\Constants\PostConstants;
use Core\Features\Post\Entities\PostEntity;
use Core\Features\Post\Models\GetPostResult;
use Core\Features\Post\Traits\MockedGetPostByIdUseCaseForTestingTrait;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidModelsForTestingTrait;
use Core\ViewModels\GetItemByIntegerIdViewModel;
use Framework\Features\PostMeta\Traits\MockedPostMetaForTestingTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetLibraryLinkByIdUseCaseTest extends TestCase {
	use ListInvalidModelsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;
	use MockedGetPostByIdUseCaseForTestingTrait;
	use MockedPostMetaForTestingTrait;

	#[DataProvider( 'getListInvalidModels' )]
	public function testInvalidModel( $model ) {
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'model' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$useCase = new GetLibraryLinkByIdUseCase();
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

		$useCase = new GetLibraryLinkByIdUseCase();
		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFound() {
		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$expectedResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => '10',
			)
		);

		$mockedGetPostResult = new GetPostResult();
		$mockedGetPostResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, PostConstants::ITEM_NAME );
		$mockedGetPostResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
		$mockedGetPostByIdUseCase = $this->getMockedGetPostByIdUseCaseInstance();
		$mockedGetPostByIdUseCase->method( 'invoke' )->willReturn( $mockedGetPostResult );

		$useCase = new GetLibraryLinkByIdUseCase();
		$useCase->setGetPostByIdUseCaseInstance( $mockedGetPostByIdUseCase );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testSuccess() {
		$expectedData = new LinkLibraryPostEntity();
		$expectedData->id = 1;
		$expectedData->title = 'post_title';

		$expectedResult = new GetLibraryLinkResult();
		$expectedResult->success = true;
		$expectedResult->data = $expectedData;

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => '10',
			)
		);

		$mockedPostData = new PostEntity();
		$mockedPostData->id = 1;
		$mockedPostData->title = 'post_title';
		$mockedGetPostResult = new GetPostResult();
		$mockedGetPostResult->success = true;
		$mockedGetPostResult->data = $mockedPostData;
		$mockedGetPostByIdUseCase = $this->getMockedGetPostByIdUseCaseInstance();
		$mockedGetPostByIdUseCase->method( 'invoke' )->willReturn( $mockedGetPostResult );

		$mockedPostMeta = $this->getMockedEmptyPostMetaInstance();
		$mockedLinkLibraryMapper = LinkLibrary::getMapper();
		$mockedLinkLibraryMapper->setPostMeta( $mockedPostMeta );

		$useCase = new GetLibraryLinkByIdUseCase();
		$useCase->setGetPostByIdUseCaseInstance( $mockedGetPostByIdUseCase );
		$useCase->setLinkLibraryMapper( $mockedLinkLibraryMapper );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
