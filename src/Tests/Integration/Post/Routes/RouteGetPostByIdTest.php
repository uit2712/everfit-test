<?php
namespace Tests\Integration\Post\Routes;

use Framework\Helpers\PathHelper;
use PHPUnit\Framework\TestCase;

class RouteGetPostByIdTest extends TestCase {
	public function testExists() {
		$apiUrl = PathHelper::getAbsPath() . '/api/v1/posts/GetById.php';
		$this->assertTrue( file_exists( $apiUrl ) );
	}
}
