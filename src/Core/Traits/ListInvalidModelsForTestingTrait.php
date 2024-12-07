<?php

namespace Core\Traits;

use stdClass;

trait ListInvalidModelsForTestingTrait {
	public static function getListInvalidModels() {
		return array(
			array( null ),
			array( new stdClass() ),
		);
	}
}
