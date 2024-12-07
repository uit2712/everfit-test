<?php
namespace Tests\Unit\LinkLibrary\Repositories\LinkLibraryRepository;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Models\Result;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Framework\Features\WordPressQuery\InterfaceAdapters\WordPressQueryRepositoryInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LinkLibraryRepositoryGetLinkByIdTest extends TestCase {
	use ListInvalidIntegersForTestingTrait;

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidId( $id ) {
		$expectedResult = new Result();
		$expectedResult->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'id' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = LinkLibrary::getRepo()->getLinkById( $id );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundPost() {
		$expectedResult = new Result();
		$expectedResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$expectedResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;

		$mockedWordPressQuery = $this->getMockBuilder( WordPressQueryRepositoryInterface::class )->getMock();
		$mockedWordPressQuery->method( 'getPostById' )->willReturn( null );

		LinkLibrary::getRepo()->setWordPressQueryRepository( $mockedWordPressQuery );
		$actualResult = LinkLibrary::getRepo()->getLinkById( 10 );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testSuccess() {
		$expectedData = JsonConverterApi::convertToJson(
			array(
				'ID' => 1,
				'post_title' => 'post_title',
				'post_content' => 'post_content',
			)
		)->data;

		$expectedResult = new Result();
		$expectedResult->success = true;
		$expectedResult->data = $expectedData;

		$mockedWordPressQuery = $this->getMockBuilder( WordPressQueryRepositoryInterface::class )->getMock();
		$mockedWordPressQuery->method( 'getPostById' )->willReturn( $expectedData );

		LinkLibrary::getRepo()->setWordPressQueryRepository( $mockedWordPressQuery );
		$actualResult = LinkLibrary::getRepo()->getLinkById( 10 );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
