<?php
namespace Framework\Features\PostMeta\Facades;

use Framework\Features\PostMeta\InterfaceAdapters\PostMetaRepositoryInterface;
use Framework\Features\PostMeta\Repositories\PostMetaRepository;

class PostMeta {
	/**
	 * @var PostMeta|null
	 */
	private static $instance;

	/**
	 * @var PostMetaRepositoryInterface|null
	 */
	private static $repo;

	private function __construct() {
	}

	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new PostMeta();
		}

		return self::$instance;
	}

	private function getRepo() {
		if ( null === self::$repo ) {
			self::$repo = new PostMetaRepository();
		}

		return self::$repo;
	}

	/**
	 * @param int|null    $postId Post id.
	 * @param string|null $key Meta key.
	 */
	public function getSingleValue( $postId, $key ): string {
		return $this->getRepo()->getSingleValue( $postId, $key )->data;
	}

	/**
	 * @param int|null    $postId Post id.
	 * @param string|null $key Meta key.
	 */
	public function getSingleValueAsInteger( $postId, $key ): int {
		return $this->getRepo()->getSingleValueAsInteger( $postId, $key )->data;
	}
}
