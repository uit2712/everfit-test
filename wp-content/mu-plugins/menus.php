<?php
function setup_custom_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'tie' ),
		)
	);
}
add_action( 'after_setup_theme', 'setup_custom_menus' );
