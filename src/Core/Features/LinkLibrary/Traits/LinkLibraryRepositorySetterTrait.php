<?php
namespace Core\Features\LinkLibrary\Traits;

use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryRepositoryInterface;

trait LinkLibraryRepositorySetterTrait {
	/**
	 * @var LinkLibraryRepositoryInterface|null
	 */
	private $linkLibraryRepo;

	/**
	 * @param LinkLibraryRepositoryInterface|null $instance Instance.
	 */
	public function setLinkLibraryRepository( $instance ) {
		if ( null !== $instance ) {
			$this->linkLibraryRepo = $instance;
		}
	}
}
