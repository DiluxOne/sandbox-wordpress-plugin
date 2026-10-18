<?php
/**
 * What the sandbox says.
 *
 * @package DiluxOne\Sandbox
 */

defined( 'ABSPATH' ) || exit;

/**
 * The greeting for a name, escaped for HTML.
 *
 * @param string $name     Who is greeted.
 * @param bool   $capitals Whether to greet in capitals, the name included.
 * @return string
 */
function dxsb_greeting( $name, $capitals = false ) {
	$name = trim( (string) $name );
	if ( '' === $name ) {
		$name = __( 'friend', 'diluxone-sandbox' );
	}
	/* translators: %s: who is greeted. */
	$greeting = sprintf( __( 'Hello, %s!', 'diluxone-sandbox' ), $name );
	if ( (bool) $capitals ) {
		// Upper-cased before escaping, so entities such as &amp; stay intact.
		$greeting = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $greeting, 'UTF-8' ) : strtoupper( $greeting );
	}
	return esc_html( $greeting );
}

/**
 * How many words a text holds.
 *
 * @param string $text The text.
 * @return int
 */
function dxsb_word_count( $text ) {
	$words = preg_split( '/\s+/', trim( (string) $text ), -1, PREG_SPLIT_NO_EMPTY );
	return count( $words );
}
