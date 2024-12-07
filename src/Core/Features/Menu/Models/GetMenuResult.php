<?php
namespace Core\Features\Menu\Models;

use Core\Features\Menu\Entities\MenuEntity;
use Core\Models\Result;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class GetMenuResult extends Result {
	/**
	 * @var MenuEntity|null
	 */
	public $data = null;
}
