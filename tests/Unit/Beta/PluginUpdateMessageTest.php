<?php
declare(strict_types=1);

namespace WPMedia\Beta\Tests\Unit\Beta;

use Mockery;
use WPMedia\Beta\Beta;
use WPMedia\Beta\Optin;
use WPMedia\Beta\Tests\Unit\TestCase;

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
	 * @var Mockery\MockInterface|Optin
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
	protected function set_up() {
		parent::set_up();

		$this->stubEscapeFunctions();

		$this->optin = Mockery::mock( Optin::class );

		$this->beta = new Beta(
			$this->optin,
			'test-plugin/test-plugin.php',
			'test_plugin',
			'1.0.0'
		);
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
		$this->optin->shouldReceive( 'is_enabled' )
			->once()
			->andReturn( $status );

		$this->beta->plugin_update_message( $data );

		if ( ! $expected ) {
			return;
		}

		$this->expectOutputContains( 'This update will install a beta version of the plugin.' );
	}
}
