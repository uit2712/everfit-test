<?php
namespace Tests\Integration\Post\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\Post\Constants\PostConstants;
use Core\Features\Post\Entities\PostEntity;
use Core\Features\Post\Models\GetPostResult;
use Core\Features\Post\UseCases\GetPostByIdUseCase;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidModelsForTestingTrait;
use Core\ViewModels\GetItemByIntegerIdViewModel;
use Framework\Features\WordPressQuery\InterfaceAdapters\WordPressQueryRepositoryInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetPostByIdUseCaseTest extends TestCase {
	use ListInvalidModelsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;

	#[DataProvider( 'getListInvalidModels' )]
	public function testInvalidModel( $model ) {
		$expectedResult = new GetPostResult();
		$expectedResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'model' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$useCase = new GetPostByIdUseCase();
		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidId( $id ) {
		$expectedResult = new GetPostResult();
		$expectedResult->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'id' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$model = new GetItemByIntegerIdViewModel(
			array(
				'id' => $id,
			)
		);

		$useCase = new GetPostByIdUseCase();
		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFound() {
		$expectedResult = new GetPostResult();
		$expectedResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, PostConstants::ITEM_NAME );
		$expectedResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;

		$model = new GetItemByIntegerIdViewModel();
		$model->id = 1;

		$mockedGetPostResult = null;
		$mockedWpQueryRepo = $this->getMockBuilder( WordPressQueryRepositoryInterface::class )->getMock();
		$mockedWpQueryRepo->method( 'getPostById' )->willReturn( $mockedGetPostResult );

		$useCase = new GetPostByIdUseCase();
		$useCase->setWordPressQueryRepository( $mockedWpQueryRepo );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testSuccess() {

		$expectedData = new PostEntity();
		$expectedData->id = 1;
		$expectedData->title = 'post_title';
		$expectedData->content = 'post_content';
		$expectedData->firstAuthorId = 10;

		$expectedResult = new GetPostResult();
		$expectedResult->success = true;
		$expectedResult->data = $expectedData;

		$model = new GetItemByIntegerIdViewModel();
		$model->id = 1;

		$mockedGetPostResult = JsonConverterApi::convertToJson(
			array(
				'ID' => 1,
				'post_title' => 'post_title',
				'post_content' => 'post_content',
				'post_author' => 10,
			)
		)->data;
		$mockedWpQueryRepo = $this->getMockBuilder( WordPressQueryRepositoryInterface::class )->getMock();
		$mockedWpQueryRepo->method( 'getPostById' )->willReturn( $mockedGetPostResult );

		$useCase = new GetPostByIdUseCase();
		$useCase->setWordPressQueryRepository( $mockedWpQueryRepo );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
