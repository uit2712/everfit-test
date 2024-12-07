<?php
namespace Core\Features\Menu\Models;

use Core\Features\Menu\Entities\MenuItemEntity;
use Core\Models\Result;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class GetListMenuItemsResult extends Result {
	/**
	 * @var MenuItemEntity[]
	 */
	public $data = array();
}
