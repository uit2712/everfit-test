<?php

namespace Core\Traits;

trait ListInvalidIntegersForTestingTrait {
	public static function getListInvalidPositiveIntegers() {
		return array(
			array( null ),
			array( '' ),
			array( '     ' ),
			array( 0 ),
			array( -1111 ),
			array( '0' ),
			array( '-99999' ),
		);
	}
}
