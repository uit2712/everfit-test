<?php
namespace Tests\Unit\Post\Mappers;

use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Features\Post\Entities\PostEntity;
use Core\Features\Post\Facades\Post;
use Core\Traits\ListInvalidOrEmptyArrayForTestingTrait;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class PostMapperMapFromDbToListEntitiesTest extends TestCase {
	use ListInvalidOrEmptyArrayForTestingTrait;

	public static function getListInvalidData() {
		return array_merge(
			self::getListInvalidOrEmptyArrays(),
			array(
				array(
					JsonConverterApi::convertToJson(
						array(
							'ID' => null,
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 0,
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => null,
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => 0,
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => 1,
							'post_content' => null,
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => 1,
							'post_content' => '',
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => 1,
							'post_content' => '    ',
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => 1,
							'post_content' => 'post_content',
							'post_title' => null,
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => 1,
							'post_content' => 'post_content',
							'post_title' => '',
						)
					)->data,
					JsonConverterApi::convertToJson(
						array(
							'ID' => 111,
							'post_author' => 1,
							'post_content' => 'post_content',
							'post_title' => '   ',
						)
					)->data,
				),
			)
		);
	}

	#[DataProvider( 'getListInvalidOrEmptyArrays' )]
	public function testInvalidData( $data ) {
		$actualResult = Post::getMapper()->mapFromDbToListEntities( $data );

		$this->assertEquals( array(), $actualResult );
	}

	public function testSuccess() {
		$data = array(
			JsonConverterApi::convertToJson(
				array(
					'ID' => 1,
					'post_author' => 1,
					'post_content' => '   post_content   ',
					'post_title' => 'post_title',
				)
			)->data,
			JsonConverterApi::convertToJson(
				array(
					'ID' => 2,
					'post_author' => 2,
					'post_content' => '   post_content_2   ',
					'post_title' => '   post_title_2',
				)
			)->data,
		);

		$expectedDataItem1 = new PostEntity();
		$expectedDataItem1->id = 1;
		$expectedDataItem1->firstAuthorId = 1;
		$expectedDataItem1->content = 'post_content';
		$expectedDataItem1->title = 'post_title';

		$expectedDataItem2 = new PostEntity();
		$expectedDataItem2->id = 2;
		$expectedDataItem2->firstAuthorId = 2;
		$expectedDataItem2->content = 'post_content_2';
		$expectedDataItem2->title = 'post_title_2';

		$expectedResult = array(
			$expectedDataItem1,
			$expectedDataItem2,
		);

		$actualResult = Post::getMapper()->mapFromDbToListEntities( $data );

		$this->assertEquals( $expectedResult, $actualResult );
	}
}
