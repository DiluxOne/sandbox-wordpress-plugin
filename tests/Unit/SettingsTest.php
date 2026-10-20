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
		Functions\expect( 'delete_option' )->once()->with( 'dxsb_name' )->andReturn( true );
		$this->assertTrue( dxsb_reset_name() );
	}

	public function test_without_the_link_nothing_is_deleted() {
		Functions\expect( 'delete_option' )->never();
		$this->assertFalse( dxsb_reset_name() );
	}
}
