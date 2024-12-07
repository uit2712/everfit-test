<?php

namespace Core\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class IntegerResult extends Result {

	public $data = 0;
}
