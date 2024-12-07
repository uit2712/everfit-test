<?php
/** *
 *
 * @package Swagger UI
 * @author Author <phamquangvi456@proton.me>
 */

require_once 'wp-load.php';

$user = wp_get_current_user();
if ( isset( $user ) === false ) {
	wp_die( 'You are not logged in' );
}

if ( in_array( 'administrator', $user->roles, true ) === false ) {
	wp_die( 'You not have permissions' );
}

?>

<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="vi">

<head>
	<meta charset="UTF-8">
	<title>Swagger UI</title>
	<link rel="stylesheet" type="text/css" href="/src/Presentation/assets/css/swagger-ui.css">
	<link rel="icon" type="image/png" href="/src/Presentation/assets/images/swagger.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="/src/Presentation/images/swagger.png" sizes="16x16" />
	<style>
	html {
		box-sizing: border-box;
		overflow: -moz-scrollbars-vertical;
		overflow-y: scroll;
	}

	*,
	*:before,
	*:after {
		box-sizing: inherit;
	}

	body {
		margin: 0;
		background: #fafafa;
	}
	</style>
</head>

<body>
	<div id="swagger-ui"></div>
	<script src="/src/Presentation/assets/js/swagger-ui-standalone-preset.js"></script>
	<script src="/src/Presentation/assets/js/swagger-ui-bundle.js"></script>
	<script>
	window.onload = function() {
		// Begin Swagger UI call region
		const ui = SwaggerUIBundle({
			url: window.location.protocol + "//" + window.location.hostname + "/openapi.json",
			dom_id: '#swagger-ui',
			deepLinking: true,
			presets: [
				SwaggerUIBundle.presets.apis,
				SwaggerUIStandalonePreset
			],
			layout: "StandaloneLayout"
		})
		// End Swagger UI call region
		window.ui = ui
	}
	</script>
</body>

</html>