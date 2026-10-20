<?php
namespace Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
		require_once dirname( __DIR__, 2 ) . '/includes/settings.php';
	}

	protected function tearDown(): void {
		unset( $_GET['dxsb_reset'] );
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test_the_link_deletes_the_name() {
		$_GET['dxsb_reset'] = '1';
		Functions\when( 'current_user_can' )->justReturn( true );
		Functions\expect( 'check_admin_referer' )->once()->with( 'dxsb_reset_name' )->andReturn( 1 );
		Functions\expect( 'delete_option' )->once()->with( 'dxsb_name' )->andReturn( true );
		$this->assertTrue( dxsb_reset_name() );
	}

	public function test_without_the_link_nothing_is_deleted() {
		Functions\expect( 'delete_option' )->never();
		$this->assertFalse( dxsb_reset_name() );
	}

	public function test_the_link_deletes_nothing_for_a_user_who_cannot_manage_options() {
		$_GET['dxsb_reset'] = '1';
		Functions\when( 'current_user_can' )->justReturn( false );
		Functions\when( 'check_admin_referer' )->justReturn( 1 );
		Functions\expect( 'delete_option' )->never();
		$this->assertFalse( dxsb_reset_name() );
	}

	public function test_the_link_deletes_nothing_without_a_valid_nonce() {
		$_GET['dxsb_reset'] = '1';
		Functions\when( 'current_user_can' )->justReturn( true );
		// check_admin_referer() dies on a missing or invalid nonce.
		Functions\when( 'check_admin_referer' )->alias(
			function () {
				throw new \RuntimeException( 'invalid nonce' );
			}
		);
		Functions\expect( 'delete_option' )->never();
		$this->expectException( \RuntimeException::class );
		dxsb_reset_name();
	}
}
