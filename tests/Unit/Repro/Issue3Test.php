<?php
namespace Tests\Unit\Repro;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

class Issue3Test extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
		require_once dirname( __DIR__, 3 ) . '/includes/greeting.php';
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test_word_count_is_zero_for_empty_or_blank_text() {
		$this->assertSame( 0, dxsb_word_count( '' ) );
		$this->assertSame( 0, dxsb_word_count( '   ' ) );
	}
}
