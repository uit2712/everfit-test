<?php
namespace Tests\Integration\LinkLibrary\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\Facades\LinkLibrary;
use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryRepositoryInterface;
use Core\Features\LinkLibrary\Models\GetListLibraryLinksResult;
use Core\Features\LinkLibrary\UseCases\GetListLibraryLinksBySlugUseCase;
use Core\Features\LinkLibrary\ViewModels\GetListLibraryLinksBySlugViewModel;
use Core\Models\ArrayResult;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidModelsForTestingTrait;
use Core\Traits\ListInvalidStringsForTestingTrait;
use Framework\Features\PostMeta\Facades\PostMeta;
use Framework\Helpers\PathHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class GetListLibraryLinksBySlugUseCaseTest extends TestCase {
	use ListInvalidModelsForTestingTrait;
	use ListInvalidStringsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;

	#[DataProvider( 'getListInvalidModels' )]
	public function testInvalidModel( $model ) {
		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->message = sprintf( ErrorMessage::INVALID_PARAMETER, 'model' );
		$expectedResult->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;

		$useCase = new GetListLibraryLinksBySlugUseCase();

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

		$useCase = new GetListLibraryLinksBySlugUseCase();

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

		$useCase = new GetListLibraryLinksBySlugUseCase();

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testNotFoundAnyPosts() {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => '10',
			)
		);

		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$expectedResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;

		$mockedGetLinksResult = new ArrayResult();
		$mockedGetLinksResult->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
		$mockedGetLinksResult->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
		$mockedLinkLibraryRepo = $this->getMockBuilder( LinkLibraryRepositoryInterface::class )->getMock();
		$mockedLinkLibraryRepo->method( 'getLinksBySlug' )->willReturn( $mockedGetLinksResult );

		$useCase = new GetListLibraryLinksBySlugUseCase();
		$useCase->setLinkLibraryRepository( $mockedLinkLibraryRepo );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}

	public function testSuccess() {
		$model = new GetListLibraryLinksBySlugViewModel(
			array(
				'slug' => 'slug',
				'total' => '10',
			)
		);

		PathHelper::loadWordPressPost();

		$expectedDataItem1 = new LinkLibraryPostEntity();
		$expectedDataItem1->id = 1;
		$expectedDataItem1->title = 'post_title';
		$expectedDataItem1->image = 'https://image.com/image.png';
		$expectedDataItem1->price = 111;
		$expectedDataItem1->description = 'description_1';
		$expectedDataItem1->largeDescription = 'large_description_1';
		$expectedDataItem1->email = '';
		$expectedDataItem1->phone = '';
		$expectedDataItem1->notes = 'notes_1';
		$expectedDataItem1->url = 'url_1';

		$expectedResult = new GetListLibraryLinksResult();
		$expectedResult->success = true;
		$expectedResult->data = array( $expectedDataItem1 );

		$mockedData1 = new stdClass();
		$mockedData1->ID = 1;
		$mockedData1->post_content = 'post_content';
		$mockedData1->post_title = 'post_title';
		$mockedData1->post_author = 1;
		$mockedGetLinksResult = new ArrayResult();
		$mockedGetLinksResult->success = true;
		$mockedGetLinksResult->data = array(
			new \WP_Post( $mockedData1 ),
		);
		$mockedLinkLibraryRepo = $this->getMockBuilder( LinkLibraryRepositoryInterface::class )->getMock();
		$mockedLinkLibraryRepo->method( 'getLinksBySlug' )->willReturn( $mockedGetLinksResult );

		$postMeta1 = array(
			array( $expectedDataItem1->id, LinkLibraryConstants::IMAGE_META_KEY, '   https://image.com/image.png' ),
			array( $expectedDataItem1->id, LinkLibraryConstants::PRICE_META_KEY, '111' ),
			array( $expectedDataItem1->id, LinkLibraryConstants::DESCRIPTION_META_KEY, '    description_1' ),
			array( $expectedDataItem1->id, LinkLibraryConstants::LARGE_DESCRIPTION_META_KEY, 'large_description_1    ' ),
			array( $expectedDataItem1->id, LinkLibraryConstants::EMAIL_META_KEY, 'email_1' ),
			array( $expectedDataItem1->id, LinkLibraryConstants::TELEPHONE_META_KEY, '   ' ),
			array( $expectedDataItem1->id, LinkLibraryConstants::NOTES_META_KEY, '    notes_1  ' ),
			array( $expectedDataItem1->id, LinkLibraryConstants::URL_META_KEY, '   url_1 ' ),
		);

		$postMetaAsInteger1 = array(
			array( $expectedDataItem1->id, LinkLibraryConstants::PRICE_META_KEY, 111 ),
		);

		$mockedPostMeta = $this->getMockBuilder( PostMeta::class )->getMock();
		$mockedPostMeta->method( 'getSingleValue' )->willReturnMap( $postMeta1 );
		$mockedPostMeta->method( 'getSingleValueAsInteger' )->willReturnMap( $postMetaAsInteger1 );

		$mapper = LinkLibrary::getMapper();
		$mapper->setPostMeta( $mockedPostMeta );
		$useCase = new GetListLibraryLinksBySlugUseCase();
		$useCase->setLinkLibraryRepository( $mockedLinkLibraryRepo );
		$useCase->setLinkLibraryMapper( $mapper );

		$actualResult = $useCase->invoke( $model );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
