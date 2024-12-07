<?php
namespace Core\Features\Post\Facades;

use Core\Features\Post\InterfaceAdapters\PostMapperInterface;
use Core\Features\Post\Mappers\PostMapper;

class Post {
	/**
	 * @var PostMapperInterface|null
	 */
	private static $mapper;

	public static function getMapper() {
		if ( null === self::$mapper ) {
			self::$mapper = new PostMapper();
		}

		return self::$mapper;
	}
}
