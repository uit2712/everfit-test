<?php
namespace Core\Features\Cache\Traits;

use Core\Features\Cache\InterfaceAdapters\CacheRepositoryInterface;

trait MockedCacheForTestingTrait {
	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject
	 */
	public function getMockedCache() {
		return $this->getMockBuilder( CacheRepositoryInterface::class )
			->disableOriginalConstructor()
			->getMock();
	}
}
