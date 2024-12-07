<?php
namespace Core\Features\LinkLibrary\InterfaceAdapters;

use Core\Features\Post\Entities\PostEntity;

interface CachedLinkLibraryMapperInterface {
	/**
	 * @param PostEntity|null $data Data.
	 */
	public function mapFromEntityToCacheItem( $data ): array;

	/**
	 * @param string       $parentKeyCache Parent key cache.
	 * @param PostEntity[] $data Data.
	 */
	public function mapFromListEntitiesToListCacheItems( $parentKeyCache, $data ): array;

	/**
	 * @param mixed $data Data.
	 *
	 * @return PostEntity|null
	 */
	public function mapFromCacheToEntity( $data );

	/**
	 * @param array $data Data.
	 *
	 * @return PostEntity[]
	 */
	public function mapFromCacheToListEntities( $data ): array;
}
