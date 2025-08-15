<?php
declare(strict_types=1);

namespace WPMedia\Beta\Tests\Unit\Beta;

use Mockery;
use WPMedia\Beta\Beta;
use WPMedia\Beta\Optin;
use WPMedia\Beta\Tests\Unit\TestCase;

/**
 * @covers WPMedia\Beta\Beta::plugin_update_message
 * @group Beta
 */
class PluginUpdateMessageTest extends TestCase {
    private $optin;
    private $beta;

    protected function set_up() {
        parent::set_up();

        $this->stubEscapeFunctions();

        $this->optin = Mockery::mock(Optin::class);

        $this->beta = new Beta(
            $this->optin,
            'test-plugin/test-plugin.php',
            'test_plugin',
            '1.0.0',
            'This is a beta update message.'
        );
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoExpected( $config, $expected ) {
        $this->optin->shouldReceive( 'is_enabled' )
            ->once()
            ->andReturn( $config['optin_enabled'] );

        $this->beta->plugin_update_message( $config['data'] );

        if ( ! $expected ) {
            return;
        }

        $this->expectOutputContains( 'This is a beta update message.' );
    }
}