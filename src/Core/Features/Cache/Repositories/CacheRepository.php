<?php
namespace Core\Features\Cache\Repositories;

use Core\Features\Cache\InterfaceAdapters\CacheRepositoryInterface;
use Core\Helpers\ArrayHelper;
use Core\Helpers\StringHelper;
use Exception;
use Redis;

class CacheRepository implements CacheRepositoryInterface {
	protected $redis = null;

	/**
	 * @param CacheConfigViewModel $param Params.
	 */
	public function init( $param ) {
		if ( null !== $this->redis ) {
			return;
		}

		try {
			$this->redis = new Redis();
			$this->redis->connect( $param->host, $param->port, $param->database, '', 100 );
			$this->redis->setOption( Redis::OPT_SERIALIZER, Redis::SERIALIZER_JSON );
		} catch ( Exception $ex ) {

		}
	}

	public function get( $key, $default = null ) {
		if ( StringHelper::isHasValue( $key ) === false ) {
			return $default;
		}

		if ( null === $this->redis ) {
			return $default;
		}

		$result = $this->redis->get( $key );
		if ( false === $result ) {
			return $default;
		}

		if ( is_array( $result ) ) {
			if ( count( $result ) > 0 ) {
				return json_decode( json_encode( $result ) );
			}

			return $default;
		}

		return $result;
	}

	public function set( $key, $value, $ttl = null ) {
		if ( StringHelper::isHasValue( $key ) === false ) {
			return false;
		}

		if ( null === $this->redis ) {
			return false;
		}

		return $this->redis->set( $key, $value, $ttl );
	}

	public function delete( $key ) {
		if ( null === $this->redis ) {
			return false;
		}

		return 1 === $this->redis->del( $key );
	}

	public function clear(): bool {
		if ( null === $this->redis ) {
			return false;
		}

		return $this->redis->flushAll();
	}

	public function getMultiple( $keys, $default = null ) {
		if ( ArrayHelper::isHasItems( $keys ) === false ) {
			return array();
		}

		if ( null === $this->redis ) {
			return array();
		}

		$values = $this->redis->mGet( $keys );

		$result = array();
		foreach ( $values as $value ) {
			if ( isset( $value ) === false || false === $value ) {
				$result[] = $default;
			} else {
				$result[] = is_array( $value ) ? json_decode( json_encode( $value ) ) : $value;
			}
		}

		return $result;
	}

	public function getMultipleKeepKeys( $keys, $default = null ) {
		if ( ArrayHelper::isHasItems( $keys ) === false ) {
			return array();
		}

		if ( null === $this->redis ) {
			return array();
		}

		$values = $this->redis->mGet( $keys );

		$result = array();
		foreach ( $values as $key => $value ) {
			if ( isset( $value ) === false || false === $value ) {
				$result[ $keys[ $key ] ] = $default;
			} else {
				$result[ $keys[ $key ] ] = is_array( $value ) ? json_decode( json_encode( $value ) ) : $value;
			}
		}

		return $result;
	}

	public function setMultiple( $values, $ttl = null ) {
		if ( ArrayHelper::isHasItems( $values ) === false ) {
			return false;
		}

		if ( null === $this->redis ) {
			return false;
		}

		return $this->redis->mSet( $values );
	}

	public function deleteMultiple( $keys ) {
		if ( ArrayHelper::isHasItems( $keys ) === false ) {
			return false;
		}

		if ( null === $this->redis ) {
			return false;
		}

		return 1 === $this->redis->del( $keys );
	}

	public function has( $key ) {
		if ( StringHelper::isHasValue( $key ) === false ) {
			return false;
		}

		if ( null === $this->redis ) {
			return false;
		}

		return $this->redis->exists( $key );
	}

	public function getKeys( string $pattern ): array {
		if ( StringHelper::isHasValue( $pattern ) === false ) {
			return array();
		}

		if ( null === $this->redis ) {
			return array();
		}

		return $this->redis->keys( $pattern );
	}
}
