<?php
/**
 * The sandbox's one setting, for administrators only.
 *
 * @package DiluxOne\Sandbox
 */

defined( 'ABSPATH' ) || exit;

/**
 * Saves the greeting's name, from the settings form.
 *
 * @return bool Whether it was saved.
 */
function dxsb_save_name() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}
	check_admin_referer( 'dxsb_save_name' );
	$name = isset( $_POST['dxsb_name'] ) ? sanitize_text_field( wp_unslash( $_POST['dxsb_name'] ) ) : '';
	return update_option( 'dxsb_name', $name );
}

/**
 * Deletes the greeting's name when an administrator loads an admin page
 * with ?dxsb_reset=1 and a valid 'dxsb_reset_name' nonce.
 *
 * @return bool Whether it was deleted.
 */
function dxsb_reset_name() {
	if ( empty( $_GET['dxsb_reset'] ) ) {
		return false;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}
	check_admin_referer( 'dxsb_reset_name' );
	return delete_option( 'dxsb_name' );
}

add_action( 'admin_post_dxsb_save_name', 'dxsb_save_name' );
add_action( 'admin_init', 'dxsb_reset_name' );
