<?php

namespace Core\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ArrayResult extends Result {

	public $data = array();
}
