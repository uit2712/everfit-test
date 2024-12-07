<?php

namespace Core\Constants;

class ErrorMessage {
	public const INVALID_PARAMETER = 'Invalid parameter `%s`';
	public const POSITIVE_PARAMETER = self::INVALID_PARAMETER . ': must > 0';
	public const POSITIVE_INCLUDE_ZERO_PARAMETER = self::INVALID_PARAMETER . ': must >= 0';
	public const REACH_MAX_INTEGER_VALUE_PARAMETER = self::INVALID_PARAMETER . ': max is %d';
	public const EMPTY_ARRAY_PARAMETER = self::INVALID_PARAMETER . ': array is empty';
	public const NULL_OR_EMPTY_PARAMETER = self::INVALID_PARAMETER . ': Null or empty';
	public const NOT_FOUND_ANY_ITEM = 'Not found any item `%s`';
	public const INVALID_DATE_PARAMETER = self::INVALID_PARAMETER . ': date is invalid';
	public const FUNCTION_NOT_EXISTS = 'Function `%s` not exists';
	public const STORE_DATA_TO_CACHE_FAILED = 'Store data to cache failed';
}
