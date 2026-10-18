<?php
/**
 * The greeting, for posts.
 *
 * @package DiluxOne\Sandbox
 */

defined( 'ABSPATH' ) || exit;

/**
 * The [dxsb_greet name="..."] shortcode: the greeting for that name.
 *
 * @param array|string $atts The shortcode's attributes.
 * @return string The greeting.
 */
function dxsb_greet_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'name' => '' ), $atts, 'dxsb_greet' );
	/* translators: %s: who is greeted. */
	return sprintf( __( 'Hello, %s!', 'diluxone-sandbox' ), $atts['name'] );
}

/**
 * Registers the sandbox's shortcodes.
 *
 * @return void
 */
function dxsb_register_shortcodes() {
	add_shortcode( 'dxsb_greet', 'dxsb_greet_shortcode' );
}

add_action( 'init', 'dxsb_register_shortcodes' );
