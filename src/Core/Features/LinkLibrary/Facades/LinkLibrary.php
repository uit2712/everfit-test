<?php
namespace Core\Features\LinkLibrary\Facades;

use Core\Features\LinkLibrary\InterfaceAdapters\CachedLinkLibraryMapperInterface;
use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryMapperInterface;
use Core\Features\LinkLibrary\InterfaceAdapters\LinkLibraryRepositoryInterface;
use Core\Features\LinkLibrary\Mappers\CachedLinkLibraryMapper;
use Framework\Features\LinkLibrary\Mappers\LinkLibraryMapper;
use Framework\Features\LinkLibrary\Repositories\LinkLibraryRepository;

class LinkLibrary {
	/**
	 * @var LinkLibraryRepositoryInterface|null
	 */
	private static $repo;

	/**
	 * @var LinkLibraryMapperInterface|null
	 */
	private static $mapper;

	/**
	 * @var CachedLinkLibraryMapperInterface|null
	 */
	private static $cachedMapper;

	public static function getRepo() {
		if ( null === self::$repo ) {
			self::$repo = new LinkLibraryRepository();
		}

		return self::$repo;
	}

	public static function getMapper() {
		if ( null === self::$mapper ) {
			self::$mapper = new LinkLibraryMapper();
		}

		return self::$mapper;
	}

	public static function getCachedMapper() {
		if ( null === self::$cachedMapper ) {
			self::$cachedMapper = new CachedLinkLibraryMapper();
		}

		return self::$cachedMapper;
	}
}
