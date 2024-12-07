<?php
namespace Core\Features\LinkLibrary\Models;

use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Models\Result;

/**
 * @OA\Schema()
 */
class GetLibraryLinkResult extends Result {
	/**
	 * @OA\Property(ref="#/components/schemas/LinkLibraryPostEntity")
	 *
	 * @var LinkLibraryPostEntity|null
	 */
	public $data = null;
}
