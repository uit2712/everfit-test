<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

define( 'WP_CACHE', true ); // Added by WP Rocket

include_once 'wp-config-db.php';

define( 'WP_SITEURL', "https://{$_SERVER['HTTP_HOST']}" );
define( 'WP_HOME', "https://{$_SERVER['HTTP_HOST']}" );

define( 'FS_METHOD', 'direct' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', 't14jou-pnTQpe8)bsfK=ohsPxZ-#oGc~NrgG@&jB>v:4ijlU^5)jOgM5{yLDt}k1' );
define( 'SECURE_AUTH_KEY', 'cG EqjoqDM` ?B]D%Y+5bT3q|.N707:<ae#hd{#q8mOcexlNw/0mO$Pb+Lx~*6T?' );
define( 'LOGGED_IN_KEY', 't0P3%.0}h!*i(,-[K)g m}jo=2rr~,jTol+5fL-.W(L-5PUjsa|c`B@o4o+P5!Tp' );
define( 'NONCE_KEY', 'U36~X>EK8rvHMtPHaT#*S;+)!&Mt+`3}ZT?u){ib%oD;:r8m:5/@GE}9e;{Q82rb' );
define( 'AUTH_SALT', '];V)b_Pj0hR&[%dMqClG(hEsD~^{=l!KBy!mSrKJNHj<F,rKpg5l|}`^vmk=Ocie' );
define( 'SECURE_AUTH_SALT', 'dRG>i5j,};LBRaj0sEjj|oYE.r_Z;irKXTF2`_4I@|#BO,kYaHpY`ax3IMP={!m@' );
define( 'LOGGED_IN_SALT', '9Ul>fe#)@oh5#4,7.Jc!%R.tx9.fOQq;(i;XB^@P0+L}S:&!LP 1sp;_yF{cYDUG' );
define( 'NONCE_SALT', 'ld<X/QypZXv_TjGRiVY!6=~.N-C9()Ha1qV=9g`5riH^_zm>`!R<MQc9(jf#B-RQ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
// Enable WP_DEBUG mode
ini_set( 'display_errors', 'Off' );
ini_set( 'error_reporting', E_ALL );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );

// ini_set( 'display_errors', 1 );
// ini_set('display_startup_errors', 1);
// ini_set( 'error_reporting', E_ALL );
// define( 'WP_DEBUG', true );
// define( 'WP_DEBUG_DISPLAY', true );
// define( 'WP_DEBUG_LOG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
