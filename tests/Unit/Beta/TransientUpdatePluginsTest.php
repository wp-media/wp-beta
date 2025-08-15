<?php
declare(strict_types=1);

namespace WPMedia\Beta\Tests\Unit\Beta;

use Brain\Monkey\Functions;
use Mockery;
use WPMedia\Beta\Beta;
use WPMedia\Beta\Optin;
use WPMedia\Beta\Tests\Unit\TestCase;

/**
 * @covers WPMedia\Beta\Beta::transient_update_plugins
 * @group Beta
 */
class TransientUpdatePluginsTest extends TestCase {
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
    public function testShouldReturnExpected( $config, $transient, $expected ) {
        $this->optin->shouldReceive( 'is_enabled' )
            ->once()
            ->andReturn( $config['optin_enabled'] );

        Functions\expect( 'get_transient' )
            ->with( 'test_plugin_trunk_version' )
            ->atMost()
            ->once()
            ->andReturn( $config['transient_trunk'] );

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