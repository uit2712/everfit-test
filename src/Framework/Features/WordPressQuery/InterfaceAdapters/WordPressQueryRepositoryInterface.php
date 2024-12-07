<?php
namespace Framework\Features\WordPressQuery\InterfaceAdapters;

interface WordPressQueryRepositoryInterface {
	/**
	 * @param array $args Arguments.
	 *
	 * @return \WP_Post[]|int[] Array of post objects or post IDs.
	 */
	public function getPosts( $args ): array;
	/**
	 * @param int|null $id Id.
	 *
	 * @return \WP_Post|null
	 */
	public function getPostById( $id );
}
