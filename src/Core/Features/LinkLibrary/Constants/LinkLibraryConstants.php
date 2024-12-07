<?php
namespace Core\Features\LinkLibrary\Constants;

class LinkLibraryConstants {
	public const ITEMS_NAME = 'library link(s)';
	public const IMAGE_META_KEY = 'link_image';
	public const PRICE_META_KEY = 'link_price';
	public const DESCRIPTION_META_KEY = 'link_description';
	public const LARGE_DESCRIPTION_META_KEY = 'link_textfield';
	public const EMAIL_META_KEY = 'link_email';
	public const TELEPHONE_META_KEY = 'link_telephone';
	public const NOTES_META_KEY = 'link_notes';
	public const URL_META_KEY = 'link_url';
	public const CACHE_GROUP = 'LinkLibrary';
	public const GET_LIST_LINKS_BY_SLUG_KEY_CACHE = self::CACHE_GROUP . ':slug_%s:total_%d';
	public const GET_LINK_BY_ID_KEY_CACHE = self::CACHE_GROUP . ':%d';
	public const GET_LINK_BY_ID_FROM_CACHE_SUCCESS_MESSAGE = 'Get link by id from cache success';
	public const GET_LINKS_BY_SLUG_FROM_CACHE_SUCCESS_MESSAGE = 'Get links by slugs from cache success';
}
