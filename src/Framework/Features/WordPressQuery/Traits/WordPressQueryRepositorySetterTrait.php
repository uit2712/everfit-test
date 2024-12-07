<?php
namespace Framework\Features\WordPressQuery\Traits;

use Framework\Features\WordPressQuery\InterfaceAdapters\WordPressQueryRepositoryInterface;

trait WordPressQueryRepositorySetterTrait {
	/**
	 * @var WordPressQueryRepositoryInterface|null
	 */
	private $wpQueryRepo;

	/**
	 * @param WordPressQueryRepositoryInterface|null $instance Instance.
	 */
	public function setWordPressQueryRepository( $instance ) {
		if ( null !== $instance ) {
			$this->wpQueryRepo = $instance;
		}
	}
}
