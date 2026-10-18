<?php
namespace Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

class ShortcodeTest extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
		Functions\stubTranslationFunctions();
		Functions\stubEscapeFunctions();
		Functions\when( 'shortcode_atts' )->alias(
			function ( $pairs, $atts ) {
				return array_merge( $pairs, array_intersect_key( (array) $atts, $pairs ) );
			}
		);
		require_once dirname( __DIR__, 2 ) . '/includes/greeting.php';
		require_once dirname( __DIR__, 2 ) . '/includes/shortcode.php';
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test_the_shortcode_greets_the_name_it_is_given() {
		$this->assertSame( 'Hello, Ada!', dxsb_greet_shortcode( array( 'name' => 'Ada' ) ) );
	}

	public function test_the_shortcode_greets_a_friend_without_a_name() {
		$this->assertSame( 'Hello, friend!', dxsb_greet_shortcode( '' ) );
	}

	public function test_the_shortcode_escapes_the_name() {
		$this->assertSame(
			'Hello, &lt;script&gt;!',
			dxsb_greet_shortcode( array( 'name' => '<script>' ) )
		);
	}

	public function test_the_shortcode_leaves_no_markup_from_the_name() {
		$this->assertSame(
			'Hello, &lt;img src=x onerror=alert(document.cookie)&gt;!',
			dxsb_greet_shortcode( array( 'name' => '<img src=x onerror=alert(document.cookie)>' ) )
		);
	}

	public function test_the_registration_adds_the_shortcode() {
		Functions\expect( 'add_shortcode' )
			->once()
			->with( 'dxsb_greet', 'dxsb_greet_shortcode' );
		dxsb_register_shortcodes();
		$this->addToAssertionCount( 1 );
	}

	/**
	 * The file hooks the registration only when it is first loaded.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_the_registration_is_hooked_to_init() {
		$this->assertNotFalse( has_action( 'init', 'dxsb_register_shortcodes' ) );
	}
}
