<?php

namespace Core\Traits;

trait ListInvalidStringsForTestingTrait {
	public static function getListInvalidStrings() {
		return array(
			array( null ),
			array( '' ),
			array( '     ' ),
			array( 1 ),
			array( 1000 ),
		);
	}
}
