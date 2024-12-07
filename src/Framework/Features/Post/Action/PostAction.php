<?php
namespace Framework\Features\Post\Action;

use Core\Features\Cache\Facades\Cache;
use Core\Features\Cache\Traits\CacheSetterTrait;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\Post\Constants\PostConstants;
use Framework\Features\Post\InterfaceAdapters\PostActionInterface;

class PostAction implements PostActionInterface {
	use CacheSetterTrait;

	public function __construct() {
		$this->cache = Cache::getInstance();
	}

	public function init() {
		if ( function_exists( 'add_action' ) === false ) {
			return;
		}

		add_action( PostConstants::UPDATE_ACTION_NAME, array( $this, 'update' ), PHP_INT_MAX, 3 );
	}

	public function update( $id, $dataAfter, $dataBefore ): void {
		$this->cache->delete(
			sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $id ),
		);
	}
}
