<?php
namespace Core\Features\Cache\Traits;

use Core\Features\Cache\Facades\Cache;

trait CacheSetterTrait {
	/**
	 * @var Cache|null
	 */
	private $cache;

	/**
	 * @param Cache $instance Instance.
	 */
	public function setCache( $instance ) {
		if ( null !== $instance ) {
			$this->cache = $instance;
		}
	}
}
