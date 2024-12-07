<?php
namespace Core\Features\LinkLibrary\InterfaceAdapters;

use Core\Models\ArrayResult;
use Core\Models\Result;
use Framework\Features\WordPressQuery\InterfaceAdapters\WordPressQueryRepositorySetterInterface;

interface LinkLibraryRepositoryInterface extends WordPressQueryRepositorySetterInterface {
	/**
	 * @param string|null $slug Slug.
	 * @param int|null    $total Total.
	 */
	public function getLinksBySlug( $slug, $total ): ArrayResult;

	/**
	 * @param int|null $id Id.
	 */
	public function getLinkById( $id ): Result;
}
