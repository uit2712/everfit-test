<?php
namespace Core\Helpers;

class ArrayHelper {
	public static function isHasItems( $value ) {
		return isset( $value ) && is_array( $value ) && count( $value ) > 0;
	}

	public static function filterValidString( $value ) {
		if ( self::isHasItems( $value ) === false ) {
			return array();
		}

		return array_values(
			array_filter(
				$value,
				function ( $item ) {
					return StringHelper::isHasValue( $item );
				}
			)
		);
	}

	public static function filterPositiveInteger( $value ) {
		if ( self::isHasItems( $value ) === false ) {
			return array();
		}

		return array_values(
			array_filter(
				$value,
				function ( $item ) {
					return NumericHelper::isPositiveInteger( $item );
				}
			)
		);
	}

	public static function getListKeys( $value, $key ) {
		if ( self::isHasItems( $value ) === false || StringHelper::isHasValue( $key ) === false ) {
			return array();
		}

		$result = array_map(
			function ( $item ) use ( $key ) {
				return $item->$key;
			},
			$value,
		);

		return array_values(
			array_filter(
				$result,
				function ( $item ) {
					return null !== $item;
				}
			)
		);
	}

	public static function filterByKey( $list, $key, $value ) {
		if ( self::isHasItems( $list ) === false || StringHelper::isHasValue( $key ) === false ) {
			return array();
		}

		return array_values(
			array_filter(
				$list,
				function ( $item ) use ( $key, $value ) {
					return $item[ $key ] === $value;
				}
			)
		);
	}

	/**
	 * @param array|null $list List.
	 * @param array|null $listExclude List exclude.
	 */
	public static function exclude( $list, $listExclude ) {
		if ( self::isHasItems( $list ) === false ) {
			return array();
		}

		if ( self::isHasItems( $listExclude ) === false ) {
			return $list;
		}

		return array_values(
			array_filter(
				$list,
				function ( $item ) use ( $listExclude ) {
					return in_array( $item, $listExclude, true ) === false;
				}
			)
		);
	}
}
