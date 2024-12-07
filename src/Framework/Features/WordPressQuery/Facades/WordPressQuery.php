<?php
namespace Framework\Features\WordPressQuery\Facades;

use Framework\Features\WordPressQuery\InterfaceAdapters\WordPressQueryRepositoryInterface;
use Framework\Features\WordPressQuery\Repositories\WordPressQueryRepository;

class WordPressQuery {
	/**
	 * @var WordPressQueryRepositoryInterface|null
	 */
	private static $repo;

	private function __construct() {
	}

	public static function getInstance() {
		if ( null === self::$repo ) {
			self::$repo = new WordPressQueryRepository();
		}

		return self::$repo;
	}

	/**
	 * @param array $args Arguments.
	 *
	 * @return \WP_Post[]|int[] Array of post objects or post IDs.
	 */
	public function getPosts( $args ) {
		return self::getInstance()->getPosts( $args );
	}
}
