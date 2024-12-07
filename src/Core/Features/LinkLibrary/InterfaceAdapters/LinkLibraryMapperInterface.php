<?php
namespace Core\Features\LinkLibrary\InterfaceAdapters;

use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\Post\Entities\PostEntity;
use Framework\Features\PostMeta\InterfaceAdapters\PostMetaSetterInterface;

interface LinkLibraryMapperInterface extends PostMetaSetterInterface {
	/**
	 * @param PostEntity|mixed $data Data.
	 */
	public function mapFromPostEntityToEntity( $data );

	/**
	 * @param PostEntity[] $data Data.
	 *
	 * @return LinkLibraryPostEntity[]
	 */
	public function mapFromListPostEntitiesToListEntities( $data );
}
