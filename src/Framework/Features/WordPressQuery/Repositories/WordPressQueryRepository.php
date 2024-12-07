<?php
namespace Framework\Features\WordPressQuery\Repositories;

use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Framework\Features\WordPressQuery\InterfaceAdapters\WordPressQueryRepositoryInterface;
use Framework\Helpers\PathHelper;

class WordPressQueryRepository implements WordPressQueryRepositoryInterface {
	public function getPosts( $args ): array {
		if ( ArrayHelper::isHasItems( $args ) === false ) {
			return array();
		}

		PathHelper::loadWordPressConfig();
		return get_posts( $args );
	}

	public function getPostById( $id ) {
		if ( NumericHelper::isPositiveInteger( $id ) === false ) {
			return null;
		}

		PathHelper::loadWordPressConfig();
		if ( function_exists( 'get_post' ) === false ) {
			return null;
		}

		return get_post( $id );
	}
}
