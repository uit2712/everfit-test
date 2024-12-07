<?php
namespace Core\Features\Post\Traits;

use Core\Features\Post\UseCases\GetPostByIdUseCase;

trait MockedGetPostByIdUseCaseForTestingTrait {
	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject
	 */
	public function getMockedGetPostByIdUseCaseInstance() {
		return $this->getMockBuilder( GetPostByIdUseCase::class )->getMock();
	}
}
