<?php

namespace Core\Features\JsonConverter\Facades;

use Core\Features\JsonConverter\InterfaceAdapters\JsonConverterRepositoryInterface;
use Core\Features\JsonConverter\Repositories\JsonConverterRepository;

class JsonConverter {

	/**
	 * @var JsonConverterRepositoryInterface|null
	 */
	private static $repo;

	public static function getRepo() {
		if ( null === self::$repo ) {
			self::$repo = new JsonConverterRepository();
		}

		return self::$repo;
	}
}
