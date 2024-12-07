<?php
namespace Tests\Integration\LinkLibrary\Routes;

use Framework\Helpers\PathHelper;
use PHPUnit\Framework\TestCase;

class RouteGetListLibraryLinksBySlugTest extends TestCase {
	public function testExists() {
		$apiUrl = PathHelper::getAbsPath() . '/api/v1/linkLibraries/GetLinksBySlug.php';
		$this->assertTrue( file_exists( $apiUrl ) );
	}
}
