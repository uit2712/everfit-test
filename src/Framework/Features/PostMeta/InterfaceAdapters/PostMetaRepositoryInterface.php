<?php
namespace Framework\Features\PostMeta\InterfaceAdapters;

use Core\Models\IntegerResult;
use Core\Models\StringResult;

interface PostMetaRepositoryInterface {
	/**
	 * @param int|null    $postId Post id.
	 * @param string|null $key Meta key.
	 */
	public function getSingleValue( $postId, $key ): StringResult;

	/**
	 * @param int|null    $postId Post id.
	 * @param string|null $key Meta key.
	 */
	public function getSingleValueAsInteger( $postId, $key ): IntegerResult;
}
