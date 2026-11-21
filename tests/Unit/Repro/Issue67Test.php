<?php
namespace Tests\Unit\Repro;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

class Issue67Test extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
		require_once dirname( __DIR__, 3 ) . '/includes/settings.php';
	}

	protected function tearDown(): void {
		unset( $_POST['dxsb_name'] );
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test_saving_the_name_redirects_the_administrator_back() {
		$_POST['dxsb_name'] = 'Ada';
		Functions\when( 'current_user_can' )->justReturn( true );
		Functions\when( 'check_admin_referer' )->justReturn( 1 );
		Functions\when( 'wp_unslash' )->returnArg();
		Functions\when( 'sanitize_text_field' )->returnArg();
		Functions\when( 'update_option' )->justReturn( true );
		Functions\when( 'wp_get_referer' )->justReturn( 'https://example.test/wp-admin/options-general.php?page=dxsb' );
		Functions\when( 'admin_url' )->alias(
			function ( $path = '' ) {
				return 'https://example.test/wp-admin/' . $path;
			}
		);
		Functions\when( 'add_query_arg' )->alias(
			function ( $key, $value, $url ) {
				return $url . ( false === strpos( $url, '?' ) ? '?' : '&' ) . $key . '=' . $value;
			}
		);

		$redirected = false;
		// The fix redirects and then exits; the stub throws so exit is never reached.
		Functions\when( 'wp_safe_redirect' )->alias(
			function () use ( &$redirected ) {
				$redirected = true;
				throw new \RuntimeException( 'redirected' );
			}
		);

		try {
			dxsb_save_name();
		} catch ( \RuntimeException $e ) {
			$this->assertSame( 'redirected', $e->getMessage() );
		}

		$this->assertTrue( $redirected, 'dxsb_save_name() saved the option but never called wp_safe_redirect(), leaving a blank admin-post.php page.' );
	}
}
