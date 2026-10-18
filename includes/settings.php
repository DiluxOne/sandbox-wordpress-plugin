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
