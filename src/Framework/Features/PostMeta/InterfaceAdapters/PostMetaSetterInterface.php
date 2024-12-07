<?php
namespace Framework\Features\PostMeta\InterfaceAdapters;

use Framework\Features\PostMeta\Facades\PostMeta;

interface PostMetaSetterInterface {
	/**
	 * @param PostMeta|null $instance Instance.
	 */
	public function setPostMeta( $instance );
}
