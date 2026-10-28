<?php
namespace Tests\Unit\Repro;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

class Issue56Test extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * The plugin hooks its files only when they are first loaded.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_the_settings_form_submission_is_hooked_to_the_save_handler() {
		require_once dirname( __DIR__, 3 ) . '/diluxone-sandbox.php';

		$hooked = false;
		foreach ( array( 'admin_post_dxsb_save_name', 'admin_init' ) as $hook ) {
			if ( false !== has_action( $hook, 'dxsb_save_name' ) ) {
				$hooked = true;
			}
		}
		$this->assertTrue( $hooked, 'dxsb_save_name() is not hooked to the settings form submission.' );
	}
}
