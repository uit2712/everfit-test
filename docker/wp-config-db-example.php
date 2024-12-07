<?php
if ( defined( 'DB_NAME' ) === false ) {
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'wp' );
}

if ( defined( 'DB_USER' ) === false ) {
	/** Database username */
	define( 'DB_USER', 'root' );
}

if ( defined( 'DB_PASSWORD' ) === false ) {
	/** Database password */
	define( 'DB_PASSWORD', '123456' );
}

if ( defined( 'DB_HOST' ) === false ) {
	/** Database hostname */
	define( 'DB_HOST', 'db' );
}

if ( defined( 'DB_CHARSET' ) === false ) {
	/** Database charset to use in creating database tables. */
	define( 'DB_CHARSET', 'utf8' );
}

if ( defined( 'DB_COLLATE' ) === false ) {
	/** The database collate type. Don't change this if in doubt. */
	define( 'DB_COLLATE', '' );
}

if ( defined( 'WP_DB_COLLATION' ) === false ) {
	define( 'WP_DB_COLLATION', 'utf8mb4_unicode_ci' );
}
