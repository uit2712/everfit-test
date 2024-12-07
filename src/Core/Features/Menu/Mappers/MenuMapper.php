<?php
namespace Core\Features\Menu\Mappers;

use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Core\Helpers\StringHelper;
use Core\Features\Menu\Entities\MenuEntity;
use Core\Features\Menu\Entities\MenuItemEntity;
use Core\Features\Menu\InterfaceAdapters\MenuMapperInterface;

class MenuMapper implements MenuMapperInterface {
	public function mapFromDbToEntity( $data, $location = '' ) {
		if ( null === $data ) {
			return null;
		}

		$result = new MenuEntity();
		if ( NumericHelper::isPositiveInteger( $data->term_id ) ) {
			$result->id = $data->term_id;
		}

		if ( StringHelper::isHasValue( $data->name ) ) {
			$result->name = trim( $data->name );
		}

		if ( StringHelper::isHasValue( $data->slug ) ) {
			$result->slug = trim( $data->slug );
		}
		$result->location = trim( $location );

		return $result;
	}

	public function mapFromDbToMenuItemEntity( $data ) {
		if ( null === $data ) {
			return null;
		}

		if ( StringHelper::isHasValue( $data->title ) === false || StringHelper::isHasValue( $data->url ) === false ) {
			return null;
		}

		$result = new MenuItemEntity();
		if ( NumericHelper::isPositiveInteger( $data->ID ) ) {
			$result->id = $data->ID;
		}

		if ( isset( $data->title ) && StringHelper::isHasValue( $data->title ) ) {
			$result->title = trim( $data->title );
		}

		if ( isset( $data->url ) && StringHelper::isHasValue( $data->url ) ) {
			$result->url = trim( $data->url );
		}

		if ( isset( $data->imageUrl ) && StringHelper::isHasValue( $data->imageUrl ) ) {
			$result->imageUrl = trim( $data->imageUrl );
		}

		if ( isset( $data->imageHtml ) && StringHelper::isHasValue( $data->imageHtml ) ) {
			$result->imageHtml = trim( $data->imageHtml );
		}

		if ( isset( $data->classes ) && ArrayHelper::isHasItems( $data->classes ) ) {
			$result->classes = trim( implode( ' ', $data->classes ) );
		}

		if ( isset( $data->iconHtml ) && StringHelper::isHasValue( $data->iconHtml ) ) {
			$result->iconHtml = trim( $data->iconHtml );
		}

		if ( isset( $data->menu_item_parent ) && StringHelper::isHasValue( $data->menu_item_parent ) ) {
			$result->parentId = intval( $data->menu_item_parent );
		}

		if ( isset( $data->object_id ) && StringHelper::isHasValue( $data->object_id ) ) {
			$result->objectId = intval( $data->object_id );
		}

		if ( isset( $data->type ) && StringHelper::isHasValue( $data->type ) ) {
			$result->objectType = trim( $data->type );
		}

		return $result;
	}

	public function mapFromDbToListMenuItemEntities( $data ) {
		$result = array();
		if ( ArrayHelper::isHasItems( $data ) === false ) {
			return $result;
		}

		foreach ( $data as $item ) {
			$mappedItem = $this->mapFromDbToMenuItemEntity( $item );
			if ( null !== $mappedItem ) {
				$result[] = $mappedItem;
			}
		}

		return $result;
	}
}
