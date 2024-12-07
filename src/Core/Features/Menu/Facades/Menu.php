<?php
namespace Core\Features\Menu\Facades;

use Core\Features\Menu\InterfaceAdapters\MenuMapperInterface;
use Core\Features\Menu\InterfaceAdapters\MenuRepositoryInterface;
use Core\Features\Menu\Mappers\MenuMapper;
use Framework\Features\Menu\Repositories\MenuRepository;

class Menu {
	/**
	 * @var MenuMapperInterface
	 */
	private static $mapper;

	/**
	 * @var MenuRepositoryInterface
	 */
	private static $repo;

	public static function getMapper() {
		if ( null === self::$mapper ) {
			self::$mapper = new MenuMapper();
		}

		return self::$mapper;
	}

	public static function getRepo() {
		if ( null === self::$repo ) {
			self::$repo = new MenuRepository();
		}

		return self::$repo;
	}
}
