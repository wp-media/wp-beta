<?php
declare(strict_types=1);

namespace WPMedia\Beta\Tests\Integration\Beta;

use WPMedia\Beta\Beta;
use WPMedia\Beta\Optin;
use WPMedia\Beta\Tests\Integration\TestCase;

/**
 * Test the plugin update message output.
 *
 * @covers WPMedia\Beta\Beta::plugin_update_message
 * @group Beta
 */
class PluginUpdateMessageTest extends TestCase {
	/**
	 * Optin instance.
	 *
	 * @var Optin
	 */
	private $optin;

	/**
	 * Beta instance.
	 *
	 * @var Beta
	 */
	private $beta;

	/**
	 * Set up the test environment.
	 */
	public function set_up() {
		parent::set_up();

		$this->optin = new Optin( 'test_plugin', 'manage_options' );

		$this->beta = new Beta(
			$this->optin,
			'test-plugin/test-plugin.php',
			'test_plugin',
			'1.0.0',
			'This is a beta update message.'
		);
	}

	/**
	 * Clean up the test environment.
	 */
	public function tear_down() {
		delete_option( 'test_plugin_beta_optin' );

		parent::tear_down();
	}

	/**
	 * Test the plugin update message output.
	 *
	 * @dataProvider configTestData
	 *
	 * @param bool     $status   Whether the beta is enabled.
	 * @param string[] $data     The data array.
	 * @param bool     $expected Whether the output is expected.
	 *
	 * @return void
	 */
	public function testShouldDoExpected( $status, $data, $expected ): void {
		$user = self::factory()->user->create( [ 'role' => 'administrator' ] );

		if ( $user instanceof \WP_Error ) {
			$this->fail( 'Failed to create user' );
		}

		wp_set_current_user( $user );

		update_option( 'test_plugin_beta_optin', $status );

		$this->beta->plugin_update_message( $data );

		if ( ! $expected ) {
			$this->expectOutputString( '' );

			return;
		}

		$this->expectOutputContains( 'This is a beta update message.' );
	}
}
