<?php
namespace Framework\Features\LinkLibrary\Mappers;

use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\Entities\LinkLibraryPostEntity;
use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryMapperInterface;
use Core\Features\Post\Entities\PostEntity;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Core\Helpers\StringHelper;
use Framework\Features\PostMeta\Facades\PostMeta;
use Framework\Features\PostMeta\Traits\PostMetaSetterTrait;

class LinkLibraryMapper implements LinkLibraryMapperInterface {
	use PostMetaSetterTrait;

	public function __construct() {
		$this->postMeta = PostMeta::getInstance();
	}

	public function mapFromPostEntityToEntity( $data ) {
		if (
			null === $data ||
			is_object( $data ) === false ||
			false === ( $data instanceof PostEntity )
		) {
			return null;
		}

		if (
			NumericHelper::isPositiveInteger( $data->id ) === false ||
			StringHelper::isHasValue( $data->title ) === false
		) {
			return null;
		}

		$result = new LinkLibraryPostEntity();
		$result->id = $data->id;
		$result->title = StringHelper::trim( $data->title );

		$imageUrl = $this->postMeta->getSingleValue( $result->id, LinkLibraryConstants::IMAGE_META_KEY );
		if ( StringHelper::isHasValue( $imageUrl ) ) {
			$result->image = StringHelper::trim( $imageUrl );
		}

		$description = $this->postMeta->getSingleValue( $result->id, LinkLibraryConstants::DESCRIPTION_META_KEY );
		if ( StringHelper::isHasValue( $description ) ) {
			$result->description = StringHelper::trim( $description );
		}

		$largeDescription = $this->postMeta->getSingleValue( $result->id, LinkLibraryConstants::LARGE_DESCRIPTION_META_KEY );
		if ( StringHelper::isHasValue( $largeDescription ) ) {
			$result->largeDescription = StringHelper::trim( $largeDescription );
		}

		$notes = $this->postMeta->getSingleValue( $result->id, LinkLibraryConstants::NOTES_META_KEY );
		if ( StringHelper::isHasValue( $notes ) ) {
			$result->notes = StringHelper::trim( $notes );
		}

		$price = $this->postMeta->getSingleValueAsInteger( $result->id, LinkLibraryConstants::PRICE_META_KEY );
		if ( NumericHelper::isPositiveInteger( $price ) ) {
			$result->price = intval( $price );
		}

		$url = $this->postMeta->getSingleValue( $result->id, LinkLibraryConstants::URL_META_KEY );
		if ( StringHelper::isHasValue( $url ) ) {
			$result->url = StringHelper::trim( $url );
		}

		return $result;
	}

	public function mapFromListPostEntitiesToListEntities( $data ) {
		$result = array();
		if ( ArrayHelper::isHasItems( $data ) === false ) {
			return $result;
		}

		foreach ( $data as $item ) {
			$mappedItem = $this->mapFromPostEntityToEntity( $item );
			if ( null !== $mappedItem ) {
				$result[] = $mappedItem;
			}
		}

		return $result;
	}
}
