<?php
namespace Core\Features\LinkLibrary\InterfaceAdapters;

interface LinkLibraryRepositorySetterInterface {
	/**
	 * @param LinkLibraryRepositoryInterface|null $instance Instance.
	 */
	public function setLinkLibraryRepository( $instance );
}
