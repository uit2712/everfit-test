<?php
namespace Core\Features\Cache\Config;

use Core\Features\Cache\Facades\Cache;
use Core\Features\Cache\ViewModels\CacheConfigViewModel;
use Framework\Helpers\PathHelper;

PathHelper::loadRedisConfig();
if ( defined( 'WP_REDIS_HOST' ) === false ) {
	return;
}

$cacheParam = new CacheConfigViewModel();
$cacheParam->setHost( WP_REDIS_HOST );
if ( defined( 'WP_REDIS_DATABASE' ) ) {
	$cacheParam->setDatabase( WP_REDIS_DATABASE );
}
if ( defined( 'WP_REDIS_PORT' ) ) {
	$cacheParam->setPort( WP_REDIS_PORT );
}
Cache::getInstance()->init( $cacheParam );
