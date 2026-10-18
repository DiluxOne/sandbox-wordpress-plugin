<?php
namespace Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

class GreetingTest extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
		Functions\stubTranslationFunctions();
		Functions\stubEscapeFunctions();
		require_once dirname( __DIR__, 2 ) . '/includes/greeting.php';
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test_it_greets_a_name() {
		$this->assertSame( 'Hello, Ada!', dxsb_greeting( 'Ada' ) );
	}

	public function test_it_greets_a_friend_when_there_is_no_name() {
		$this->assertSame( 'Hello, friend!', dxsb_greeting( '  ' ) );
	}

	public function test_it_counts_words() {
		$this->assertSame( 3, dxsb_word_count( 'one two  three' ) );
	}
}
