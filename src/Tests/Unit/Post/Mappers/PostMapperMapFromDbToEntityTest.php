<?php
namespace Tests\Unit\Post\Mappers;

use Core\Features\Post\Facades\Post;
use Core\Traits\ListInvalidIntegersForTestingTrait;
use Core\Traits\ListInvalidObjectsForTestingTrait;
use Core\Traits\ListInvalidStringsForTestingTrait;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;

class PostMapperMapFromDbToEntityTest extends TestCase {
	use ListInvalidObjectsForTestingTrait;
	use ListInvalidIntegersForTestingTrait;
	use ListInvalidStringsForTestingTrait;

	#[DataProvider( 'getListInvalidObjects' )]
	public function testInvalidData( $data ) {
		$actualResult = Post::getMapper()->mapFromDbToEntity( $data );

		$this->assertNull( $actualResult );
	}

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidId( $id ) {
		$data = new stdClass();
		$data->ID = $id;

		$actualResult = Post::getMapper()->mapFromDbToEntity( $data );

		$this->assertNull( $actualResult );
	}

	#[DataProvider( 'getListInvalidPositiveIntegers' )]
	public function testInvalidFirstAuthorId( $id ) {
		$data = new stdClass();
		$data->ID = 123;
		$data->post_author = $id;

		$actualResult = Post::getMapper()->mapFromDbToEntity( $data );

		$this->assertNull( $actualResult );
	}

	#[DataProvider( 'getListInvalidStrings' )]
	public function testInvalidContent( $content ) {
		$data = new stdClass();
		$data->ID = 123;
		$data->post_author = 456;
		$data->post_content = $content;

		$actualResult = Post::getMapper()->mapFromDbToEntity( $data );

		$this->assertNull( $actualResult );
	}
}
