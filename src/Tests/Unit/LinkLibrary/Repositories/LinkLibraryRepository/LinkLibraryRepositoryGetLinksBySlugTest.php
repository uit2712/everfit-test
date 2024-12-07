<?php
namespace Tests\Unit\LinkLibrary\Repositories\LinkLibraryRepository;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Models\ArrayResult;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidStringsForTestingTrait;
use Framework\Features\WordPressQuery\InterfaceAdapters\WordPressQueryRepositoryInterface;
use Framework\Helpers\PathHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class LinkLibraryRepositoryGetLinksBySlugTest extends TestCase {
	use ListInvalidStringsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;

	#[DataProvider( 'getListInvalidStrings' )]
	public function testInvalidSlug( $slug ) {
		$expectedResult = new ArrayResult();
		$expectedResult->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'slug' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = LinkLibrary::getRepo()->getLinksBySlug( $slug, null );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidTotal( $total ) {
		$expectedResult = new ArrayResult();
		$expectedResult->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'total' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$actualResult = LinkLibrary::getRepo()->getLinksBySlug( 'slug', $total );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundAnyPosts() {
		$expectedResult = new ArrayResult();
		$expectedResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$expectedResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;

		$mockedWordPressQuery = $this->getMockBuilder( WordPressQueryRepositoryInterface::class )->getMock();
		$mockedWordPressQuery->method( 'getPosts' )->willReturn( array() );

		LinkLibrary::getRepo()->setWordPressQueryRepository( $mockedWordPressQuery );
		$actualResult = LinkLibrary::getRepo()->getLinksBySlug( 'slug', 10 );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testSuccess() {
		PathHelper::loadWordPressPost();

		$mockedData1 = new stdClass();
		$mockedData1->ID = 1;
		$mockedData1->post_content = 'post_content';
		$mockedData1->post_title = 'post_title';
		$mockedData1->post_author = 1;
		$mockedGetPostsResult = array(
			new \WP_Post( $mockedData1 ),
		);

		$expectedResult = new ArrayResult();
		$expectedResult->success = true;
		$expectedResult->data = $mockedGetPostsResult;

		$mockedWordPressQuery = $this->getMockBuilder( WordPressQueryRepositoryInterface::class )->getMock();
		$mockedWordPressQuery->method( 'getPosts' )->willReturn( $mockedGetPostsResult );

		LinkLibrary::getRepo()->setWordPressQueryRepository( $mockedWordPressQuery );
		$actualResult = LinkLibrary::getRepo()->getLinksBySlug( 'slug', 10 );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
