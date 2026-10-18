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
 * @param string $name Who is greeted.
 * @return string
 */
function dxsb_greeting( $name ) {
	$name = trim( (string) $name );
	if ( '' === $name ) {
		$name = __( 'friend', 'diluxone-sandbox' );
	}
	/* translators: %s: who is greeted. */
	return esc_html( sprintf( __( 'Hello, %s!', 'diluxone-sandbox' ), $name ) );
}

/**
 * How many words a text holds.
 *
 * @param string $text The text.
 * @return int
 */
function dxsb_word_count( $text ) {
	$words = preg_split( '/\s+/', trim( (string) $text ) );
	return count( $words );
}
