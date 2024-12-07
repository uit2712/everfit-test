<?php
namespace Framework\Features\WordPressQuery\InterfaceAdapters;

interface WordPressQueryRepositorySetterInterface {
	/**
	 * @param WordPressQueryRepositoryInterface|null $instance Instance.
	 */
	public function setWordPressQueryRepository( $instance );
}
