<?php
namespace Framework\Features\PostMeta\Traits;

use Framework\Features\PostMeta\Facades\PostMeta;

trait MockedPostMetaForTestingTrait {
	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject
	 */
	public function getMockedPostMetaInstance() {
		return $this->getMockBuilder( PostMeta::class )
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject
	 */
	public function getMockedEmptyPostMetaInstance() {
		$result = $this->getMockBuilder( PostMeta::class )
			->disableOriginalConstructor()
			->getMock();
		$result->method( 'getSingleValue' )->willReturn( '' );
		return $result;
	}
}
