<?php
namespace Core\Features\LinkLibrary\Traits;

use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryMapperInterface;

trait LinkLibraryMapperSetterTrait {
	/**
	 * @var LinkLibraryMapperInterface|null
	 */
	private $linkLibraryMapper;

	/**
	 * @param LinkLibraryMapperInterface|null $instance Instance.
	 */
	public function setLinkLibraryMapper( $instance ) {
		if ( null !== $instance ) {
			$this->linkLibraryMapper = $instance;
		}
	}
}
