<?php
namespace Core\Features\LinkLibrary\Traits;

use Core\Features\LinkLibrary\UseCases\GetLibraryLinkByIdUseCase;

trait MockedGetLibraryLinkByIdUseCaseForTestingTrait {
	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject
	 */
	public function getMockedGetLibraryLinkByIdUseCaseInstance() {
		return $this->getMockBuilder( GetLibraryLinkByIdUseCase::class )->getMock();
	}
}
