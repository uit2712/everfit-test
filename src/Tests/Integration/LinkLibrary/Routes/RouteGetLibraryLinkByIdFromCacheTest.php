<?php
namespace Tests\Integration\LinkLibrary\Routes;

use Framework\Helpers\PathHelper;
use PHPUnit\Framework\TestCase;

class RouteGetLibraryLinkByIdFromCacheTest extends TestCase {
	public function testExists() {
		$apiUrl = PathHelper::getAbsPath() . '/api/v1/linkLibraries/GetLinkByIdFromCache.php';
		$this->assertTrue( file_exists( $apiUrl ) );
	}
}
