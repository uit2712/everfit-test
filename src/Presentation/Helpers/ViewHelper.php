<?php

namespace Presentation\Helpers;

use Exception;

class ViewHelper {
	/**
	 * Get views html in folder Presentation
	 *
	 * @param string $path Path (not include Presentation, example: Views/Newsletter/FormSubscription/Views/FormSubscription.php).
	 */
	public static function get( string $path, array $vars = array() ) {
		try {
			// phpcs:ignore
			extract( $vars );
			ob_start();
			include dirname( __DIR__ ) . '/' . $path;
			return ob_get_clean();
		} catch ( Exception $ex ) {
			return '';
		}
	}

	/**
	 * Get views html in folder Presentation
	 *
	 * @param string $path Path (not include Presentation, example: Views/Newsletter/FormSubscription/Views/FormSubscription.php).
	 */
	public static function render( string $path, array $vars = array() ) {
		try {
			// phpcs:ignore
			extract( $vars );
			include dirname( __DIR__ ) . '/' . $path;
			// phpcs:ignore
		} catch ( Exception $ex ) {
		}
	}
}
