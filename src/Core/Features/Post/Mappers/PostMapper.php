<?php
namespace Core\Features\Post\Mappers;

use Core\Features\Post\Entities\PostEntity;
use Core\Features\Post\InterfaceAdapters\PostMapperInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Core\Helpers\StringHelper;

class PostMapper implements PostMapperInterface {
	public function mapFromDbToEntity( $data ) {
		if ( null === $data || is_object( $data ) === false ) {
			return null;
		}

		if ( isset( $data->ID ) === false ||
			NumericHelper::isPositiveInteger( $data->ID ) === false ||
			isset( $data->post_author ) === false ||
			NumericHelper::isPositiveInteger( $data->post_author ) === false ||
			isset( $data->post_title ) === false ||
			StringHelper::isHasValue( $data->post_title ) === false
		) {
			return null;
		}

		$result = new PostEntity();
		$result->id = intval( $data->ID );
		$result->firstAuthorId = intval( $data->post_author );
		$result->content = StringHelper::trim( $data->post_content );
		$result->title = StringHelper::trim( $data->post_title );

		return $result;
	}

	public function mapFromDbToListEntities( $data ) {
		$result = array();
		if ( ArrayHelper::isHasItems( $data ) === false ) {
			return $result;
		}

		foreach ( $data as $item ) {
			$mappedItem = $this->mapFromDbToEntity( $item );
			if ( null !== $mappedItem ) {
				$result[] = $mappedItem;
			}
		}

		return $result;
	}
}
