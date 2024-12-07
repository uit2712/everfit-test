<?php

namespace Core\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class StringResult extends Result {

	public $data = '';
}
