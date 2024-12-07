<?php
namespace Core\Helpers;

use Core\Constants\HttpMethod;
use Exception;

class RequestHelper {
	public static function getRequestBodyFromPhpInputAsArray() {
		// phpcs:ignore
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		if ( in_array( $httpMethod, array( HttpMethod::PUT, HttpMethod::POST, HttpMethod::DELETE, HttpMethod::PATCH ) ) === false ) {
			return array();
		}

		try {
			return json_decode( self::getRequestBodyFromPhpInput(), true );
		} catch ( Exception $ex ) {
			return array();
		}
	}

	public static function getRequestBodyFromPhpInputAsJson( $default = null ) {
		// phpcs:ignore
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		if ( in_array( $httpMethod, array( HttpMethod::PUT, HttpMethod::POST, HttpMethod::DELETE, HttpMethod::PATCH ) ) === false ) {
			return $default;
		}

		try {
			return json_decode( self::getRequestBodyFromPhpInput() );
		} catch ( Exception $ex ) {
			return $default;
		}
	}

	public static function getRequestBodyFromPhpInput() {
		// phpcs:ignore
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		if ( in_array( $httpMethod, array( HttpMethod::PUT, HttpMethod::POST, HttpMethod::DELETE, HttpMethod::PATCH ) ) === false ) {
			return null;
		}

		try {
			return file_get_contents( 'php://input' );
		} catch ( Exception $ex ) {
			return null;
		}
	}

	public static function getRequestCookiesAsArray() {
		return $_COOKIE;
	}

	public static function getBearerToken() {
		$headers = self::getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if ( ! empty( $headers ) ) {
			if ( preg_match( '/Bearer\s(\S+)/', $headers, $matches ) ) {
				return $matches[1];
			}
		}
		return null;
	}

	/**
	 * Get header Authorization
	 * */
	private static function getAuthorizationHeader() {
		$headers = null;
		if ( isset( $_SERVER['Authorization'] ) ) {
			//phpcs:ignore
			$headers = trim( $_SERVER['Authorization'] );
		} else if ( isset( $_SERVER['HTTP_AUTHORIZATION'] ) ) { // Nginx or fast CGI
			//phpcs:ignore
			$headers = trim( $_SERVER['HTTP_AUTHORIZATION'] );
		} elseif ( function_exists( 'apache_request_headers' ) ) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine( array_map( 'ucwords', array_keys( $requestHeaders ) ), array_values( $requestHeaders ) );
			// print_r($requestHeaders);
			if ( isset( $requestHeaders['Authorization'] ) ) {
				$headers = trim( $requestHeaders['Authorization'] );
			}
		}
		return $headers;
	}
}
