<?php
namespace Framework\Features\LinkLibrary\Repositories;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\LinkLibrary\Constants\LinkLibraryConstants;
use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryRepositoryInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumericHelper;
use Core\Helpers\StringHelper;
use Core\Models\ArrayResult;
use Core\Models\Result;
use Framework\Constants\PostStatus;
use Framework\Constants\PostType;
use Framework\Constants\SortBy;
use Framework\Constants\TermTaxonomy;
use Framework\Constants\WPQueryArgumentsConstants;
use Framework\Features\WordPressQuery\Facades\WordPressQuery;
use Framework\Features\WordPressQuery\Traits\WordPressQueryRepositorySetterTrait;

class LinkLibraryRepository implements LinkLibraryRepositoryInterface {
	use WordPressQueryRepositorySetterTrait;

	public function __construct() {
		$this->wpQueryRepo = WordPressQuery::getInstance();
	}

	public function getLinksBySlug( $slug, $total ): ArrayResult {
		$result = new ArrayResult();
		if ( StringHelper::isHasValue( $slug ) === false ) {
			$result->message = sprintf( ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'slug' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		if ( NumericHelper::isPositiveInteger( $total ) === false ) {
			$result->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'total' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$args = array(
			WPQueryArgumentsConstants::POST_TYPE => array( PostType::LINK_LIBRARY_LINKS ),
			WPQueryArgumentsConstants::POST_STATUS => array( PostStatus::PUBLISH ),
			WPQueryArgumentsConstants::POSTS_PER_PAGE => $total,
			WPQueryArgumentsConstants::TAX_QUERY => array(
				array(
					'taxonomy' => TermTaxonomy::LINK_LIBRARY_CATEGORY,
					'field' => 'slug',
					'terms' => $slug,
				),
			),
			WPQueryArgumentsConstants::ORDER => SortBy::ASC,
			WPQueryArgumentsConstants::ORDER_BY => 'ID',
		);
		$result->data = $this->wpQueryRepo->getPosts( $args );
		$result->success = ArrayHelper::isHasItems( $result->data );
		if ( false === $result->success ) {
			$result->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
			$result->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
			return $result;
		}

		return $result;
	}

	public function getLinkById( $id ): Result {
		$result = new Result();
		if ( NumericHelper::isPositiveInteger( $id ) === false ) {
			$result->message = sprintf( ErrorMessage::POSITIVE_PARAMETER, 'id' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$result->data = $this->wpQueryRepo->getPostById( $id );
		$result->success = null !== $result->data;
		if ( false === $result->success ) {
			$result->message = sprintf( ErrorMessage::NOT_FOUND_ANY_ITEM, LinkLibraryConstants::ITEMS_NAME );
			$result->responseCode = ApiResponseCode::HTTP_NOT_FOUND;
			return $result;
		}

		return $result;
	}
}
