<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ReadmeTest extends TestCase {
	/**
	 * The readme's lines, without their line endings.
	 *
	 * @return string[]
	 */
	private function readme_lines() {
		$text = file_get_contents( dirname( __DIR__, 2 ) . '/readme.txt' );
		return preg_split( '/\r?\n/', $text );
	}

	/**
	 * The newest changelog entry, read the way release-ready.sh reads it:
	 * the first `= … =` heading after `== Changelog ==` and the lines under
	 * it, before the next heading.
	 *
	 * @return array{heading: string, lines: string[]}
	 */
	private function newest_entry() {
		$in_changelog = false;
		$heading      = null;
		$lines        = array();
		foreach ( $this->readme_lines() as $line ) {
			if ( '== Changelog ==' === $line ) {
				$in_changelog = true;
				continue;
			}
			if ( $in_changelog && preg_match( '/^= .* =$/', $line ) ) {
				if ( null !== $heading ) {
					break;
				}
				$heading = $line;
				continue;
			}
			if ( null !== $heading && '' !== trim( $line ) ) {
				$lines[] = $line;
			}
		}
		$this->assertNotNull( $heading, 'readme.txt has no changelog entry.' );
		return array(
			'heading' => $heading,
			'lines'   => $lines,
		);
	}

	private function stable_tag() {
		foreach ( $this->readme_lines() as $line ) {
			if ( preg_match( '/^Stable tag:\s*(\S+)/', $line, $matches ) ) {
				return $matches[1];
			}
		}
		return '0';
	}

	public function test_the_newest_entry_is_0_2_0() {
		$this->assertSame( '= 0.2.0 =', $this->newest_entry()['heading'] );
	}

	/**
	 * The release pull request sets the stable tag and lifts the hold together.
	 */
	public function test_the_entry_is_held_until_0_2_0_is_released() {
		$first_line = $this->newest_entry()['lines'][0] ?? '';
		if ( version_compare( $this->stable_tag(), '0.2.0', '>=' ) ) {
			$this->assertNotSame( 'Unreleased.', $first_line );
			return;
		}
		$this->assertSame( 'Unreleased.', $first_line );
	}

	public function test_the_entry_names_the_capitals_greeting() {
		$this->assertMatchesRegularExpression(
			'/^\* .*capitals/mi',
			implode( "\n", $this->newest_entry()['lines'] )
		);
	}

	public function test_the_entry_names_the_shortcode() {
		$this->assertMatchesRegularExpression(
			'/^\* .*shortcode/mi',
			implode( "\n", $this->newest_entry()['lines'] )
		);
	}
}
