<?php
namespace Core\Features\Cache\InterfaceAdapters;

use Core\Features\Cache\Facades\Cache;

interface CacheSetterInterface {
	/**
	 * @param Cache $instance Instance.
	 */
	public function setCache( $instance );
}
