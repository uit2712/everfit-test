<?php
namespace Core\Features\LinkLibrary\Traits;

use Core\Features\LinkLibrary\UseCases\GetLibraryLinkByIdFromCacheUseCase;

trait MockedGetLibraryLinkByIdFromCacheUseCaseForTestingTrait {
	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject
	 */
	public function getMockedGetLibraryLinkByIdFromCacheUseCaseInstance() {
		return $this->getMockBuilder( GetLibraryLinkByIdFromCacheUseCase::class )->getMock();
	}
}
