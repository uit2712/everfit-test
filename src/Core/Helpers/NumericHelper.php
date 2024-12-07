<?php
namespace Core\Helpers;

class NumericHelper {
	public static function isValid( $value ) {
		return isset( $value ) && is_numeric( $value );
	}

	public static function isInteger( $value ) {
		return is_int( $value );
	}

	public static function isPositiveInteger( $value ) {
		return self::isValid( $value ) && intval( $value ) > 0;
	}

	public static function isPositiveIntegerIncludeZero( $value ) {
		return self::isInteger( $value ) && $value >= 0;
	}

	public static function parseInteger( $value ) {
		return intval( $value );
	}
}
