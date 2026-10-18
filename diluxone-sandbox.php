<?php
/**
 * Plugin Name: DiluxOne Sandbox
 * Description: A toy plugin where DiluxOne's shared workflows are proved end to end. Not published anywhere.
 * Version: 0.2.0
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Author: DiluxOne
 * License: GPL-2.0-or-later
 * Text Domain: diluxone-sandbox
 *
 * @package DiluxOne\Sandbox
 */

defined( 'ABSPATH' ) || exit;

define( 'DILUXONE_SANDBOX_VERSION', '0.2.0' );

require_once __DIR__ . '/includes/greeting.php';
require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/shortcode.php';
