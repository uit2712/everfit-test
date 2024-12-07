<?php

namespace Core\Traits;

trait ListInvalidObjectsForTestingTrait {
	public static function getListInvalidObjects() {
		return array(
			array( null ),
			array( false ),
			array( true ),
			array( '' ),
			array( '     ' ),
			array( 1 ),
			array( 1000 ),
			array( array() ),
			array( '2022/10' ),
			array( '2022/10 10:10' ),
		);
	}
}
