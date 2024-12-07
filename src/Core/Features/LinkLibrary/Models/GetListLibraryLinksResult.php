<?php
namespace Core\Features\LinkLibrary\Models;

use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Models\Result;

/**
 * @OA\Schema()
 */
class GetListLibraryLinksResult extends Result {
	/**
	 * @var LinkLibraryPostEntity[]
	 */
	public $data = array();
}
