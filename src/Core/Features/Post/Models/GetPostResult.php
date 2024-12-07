<?php
namespace Core\Features\Post\Models;

use Core\Features\Post\Entities\PostEntity;
use Core\Models\Result;

/**
 * @OA\Schema()
 */
class GetPostResult extends Result {
	/**
	 * @var PostEntity|null
	 */
	public $data = null;
}
