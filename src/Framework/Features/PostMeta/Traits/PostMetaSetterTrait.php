<?php
namespace Framework\Features\PostMeta\Traits;

use Framework\Features\PostMeta\Facades\PostMeta;

trait PostMetaSetterTrait {
	/**
	 * @var PostMeta|null
	 */
	private $postMeta;

	/**
	 * @param PostMeta|null $instance Instance.
	 */
	public function setPostMeta( $instance ) {
		if ( null !== $instance ) {
			$this->postMeta = $instance;
		}
	}
}
