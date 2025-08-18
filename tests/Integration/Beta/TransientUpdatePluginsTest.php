<?php
declare(strict_types=1);

namespace WPMedia\Beta\Tests\Integration\Beta;

use WPMedia\Beta\Beta;
use WPMedia\Beta\Optin;
use WPMedia\Beta\Tests\Integration\TestCase;

/**
 * Test the transient update plugins functionality.
 *
 * @covers WPMedia\Beta\Beta::transient_update_plugins
 * @group Beta
 */
class TransientUpdatePluginsTest extends TestCase {
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
		$this->beta  = new Beta(
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
		delete_transient( 'test_plugin_trunk_version' );

		parent::tear_down();
	}

	/**
	 * Test the transient update plugins functionality.
	 *
	 * @dataProvider configTestData
	 *
	 * @param mixed[]   $config    The configuration for the test.
	 * @param \stdClass $transient The transient object.
	 * @param \stdClass $expected  The expected result.
	 *
	 * @return void
	 */
	public function testShouldReturnExpected( $config, $transient, $expected ): void {
		$user = self::factory()->user->create( [ 'role' => 'administrator' ] );

		if ( $user instanceof \WP_Error ) {
			$this->fail( 'Failed to create user' );
		}

		wp_set_current_user( $user );

		update_option( 'test_plugin_beta_optin', $config['optin_enabled'] );

		set_transient( 'test_plugin_trunk_version', $config['transient_trunk'] );

		$transient = $this->beta->transient_update_plugins( $transient );

		$this->assertEquals(
			$expected->response,
			$transient->response
		);

		$this->assertEquals(
			$expected->no_update,
			$transient->no_update
		);
	}
}
