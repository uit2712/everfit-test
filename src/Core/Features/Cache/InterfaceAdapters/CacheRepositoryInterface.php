<?php
namespace Core\Features\Cache\InterfaceAdapters;

use Core\Features\Cache\ViewModels\CacheConfigViewModel;
use Psr\SimpleCache\CacheInterface;

interface CacheRepositoryInterface extends CacheInterface {
	/**
	 * @param CacheConfigViewModel $param Params.
	 */
	public function init( $param );

	/**
	 * Returns the keys that match a certain pattern.
	 *
	 * @param string $pattern Pattern.
	 *
	 * @return string[]
	 */
	public function getKeys( string $pattern ): array;

	/**
	 * Obtains multiple cache items by their unique keys.
	 *
	 * @param iterable $keys    A list of keys that can obtained in a single operation.
	 * @param mixed    $default Default value to return for keys that do not exist.
	 *
	 * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
	 *
	 * @throws \Psr\SimpleCache\InvalidArgumentException MUST be thrown if $keys is neither an array nor a Traversable, or if any of the $keys are not a legal value.
	 */
	public function getMultipleKeepKeys( $keys, $default = null );
}
