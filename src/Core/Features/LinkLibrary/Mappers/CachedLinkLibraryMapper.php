<?php
namespace Core\Features\LinkLibrary\Mappers;

use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\InterfaceAdapters\CachedLinkLibraryMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Core\Helpers\StringHelper;

class CachedLinkLibraryMapper implements CachedLinkLibraryMapperInterface {
	public function mapFromEntityToCacheItem( $data ): array {
		$result = array();
		if (
			null === $data ||
			is_object( $data ) === false ||
			false === ( $data instanceof LinkLibraryPostEntity )
		) {
			return $result;
		}

		if ( NumericHelper::isPositiveInteger( $data->id ) === false ) {
			return $result;
		}

		$keyCache = sprintf( LinkLibraryConstants::GET_LINK_BY_ID_KEY_CACHE, $data->id );
		$result[ $keyCache ] = $data;

		return $result;
	}

	public function mapFromListEntitiesToListCacheItems( $parentKeyCache, $data ): array {
		$result = array();
		if ( ArrayHelper::isHasItems( $data ) === false ) {
			return $result;
		}

		$listValidItems = array_values(
			array_filter(
				$data,
				function ( $item ) {
					return $item instanceof LinkLibraryPostEntity && NumericHelper::isPositiveInteger( $item->id );
				}
			)
		);
		if ( ArrayHelper::isHasItems( $listValidItems ) === false ) {
			return $result;
		}

		$result[ $parentKeyCache ] = array_map(
			function ( $data ) {
				return $data->id;
			},
			$data,
		);
		foreach ( $data as $item ) {
			$mappedItem = $this->mapFromEntityToCacheItem( $item );
			if ( ArrayHelper::isHasItems( $mappedItem ) ) {
				$result = array_merge( $result, $mappedItem );
			}
		}

		return $result;
	}

	public function mapFromCacheToEntity( $data ) {
		if ( null === $data || is_object( $data ) === false ) {
			return null;
		}

		if (
			isset( $data->id ) === false ||
			NumericHelper::isPositiveInteger( $data->id ) === false ||
			isset( $data->title ) === false ||
			StringHelper::isHasValue( $data->title ) === false
		) {
			return null;
		}

		$result = new LinkLibraryPostEntity();
		$result->id = $data->id;
		$result->title = StringHelper::trim( $data->title );
		if ( isset( $data->createdDate ) && StringHelper::isHasValue( $data->createdDate ) ) {
			$result->createdDate = StringHelper::trim( $data->createdDate );
		}
		if ( isset( $data->url ) && StringHelper::isHasValue( $data->url ) ) {
			$result->url = StringHelper::trim( $data->url );
		}
		if ( isset( $data->largeDescription ) && StringHelper::isHasValue( $data->largeDescription ) ) {
			$result->largeDescription = StringHelper::trim( $data->largeDescription );
		}
		if ( isset( $data->image ) && StringHelper::isHasValue( $data->image ) ) {
			$result->image = StringHelper::trim( $data->image );
		}
		if ( isset( $data->price ) && NumericHelper::isPositiveInteger( $data->price ) ) {
			$result->price = $data->price;
		}
		if ( isset( $data->priceCurrency ) && StringHelper::isHasValue( $data->priceCurrency ) ) {
			$result->priceCurrency = StringHelper::trim( $data->priceCurrency );
		}
		if ( isset( $data->description ) && StringHelper::isHasValue( $data->description ) ) {
			$result->description = StringHelper::trim( $data->description );
		}
		if ( isset( $data->email ) && StringHelper::isHasValue( $data->email ) ) {
			$result->email = StringHelper::trim( $data->email );
		}
		if ( isset( $data->phone ) && StringHelper::isHasValue( $data->phone ) ) {
			$result->phone = StringHelper::trim( $data->phone );
		}
		if ( isset( $data->notes ) && StringHelper::isHasValue( $data->notes ) ) {
			$result->notes = StringHelper::trim( $data->notes );
		}

		return $result;
	}

	public function mapFromCacheToListEntities( $data ): array {
		$result = array();
		if ( ArrayHelper::isHasItems( $data ) === false ) {
			return $result;
		}

		foreach ( $data as $item ) {
			$mappedItem = $this->mapFromCacheToEntity( $item );
			if ( null !== $mappedItem ) {
				$result[] = $mappedItem;
			}
		}

		return $result;
	}
}
