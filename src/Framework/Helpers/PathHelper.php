<?php
namespace Framework\Helpers;

class PathHelper {
	public static function getAbsPath() {
		return preg_replace( '/src.*$/', '', __DIR__ );
	}

	public static function loadDbConfig() {
		$path = self::getDbConfig();
		if ( file_exists( $path ) ) {
			require_once $path;
			return true;
		}

		return false;
	}

	public static function getDbConfig() {
		$path = self::getAbsPath() . '/wp-config-db.php';
		if ( file_exists( $path ) ) {
			return $path;
		}

		return self::getWordPressConfig();
	}

	public static function getWordPressConfig() {
		$path = self::getAbsPath() . 'wp-load.php';
		if ( file_exists( $path ) ) {
			return $path;
		}

		return '';
	}

	public static function loadRedisConfig() {
		$path = self::getRedisConfig();
		if ( file_exists( $path ) ) {
			require_once $path;
			return true;
		}

		return false;
	}

	public static function getRedisConfig() {
		$path = self::getAbsPath() . '/wp-redis.php';
		if ( file_exists( $path ) ) {
			return $path;
		}

		return self::getWordPressConfig();
	}

	public static function loadWordPressConfig() {
		$path = self::getWordPressConfig();
		if ( file_exists( $path ) ) {
			require_once $path;
			return true;
		}

		return false;
	}

	public static function getWordPressPostPath() {
		return self::getAbsPath() . '/wp-includes/class-wp-post.php';
	}

	public static function loadWordPressPost() {
		$path = self::getWordPressPostPath();
		if ( file_exists( $path ) ) {
			require_once $path;
			return true;
		}

		return false;
	}
}
