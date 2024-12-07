<?php

namespace Core\Traits;

trait ListInvalidOrEmptyArrayForTestingTrait {
	public static function getListInvalidOrEmptyArrays() {
		return array(
			array( null ),
			array( '' ),
			array( '     ' ),
			array( 1 ),
			array( 1000 ),
			array( array() ),
			array( false ),
			array( true ),
		);
	}
}
