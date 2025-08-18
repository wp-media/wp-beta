<?php

$transient            = new stdClass();
$transient->response  = [];
$transient->no_update = [
	'test-plugin/test-plugin.php' => '1.0.0',
];

$beta_transient = (object) [
	'response'  => [
		'test-plugin/test-plugin.php' => (object) [
			'id'             => 'w.org/plugins/test_plugin',
			'slug'           => 'test_plugin',
			'plugin'         => 'test-plugin/test-plugin.php',
			'new_version'    => '1.1.0-beta',
			'url'            => 'https://wordpress.org/plugins/test_plugin/',
			'package'        => 'https://downloads.wordpress.org/plugin/test_plugin.zip',
			'icons'          => [
				'2x'  => 'https://ps.w.org/test_plugin/assets/icon-256x256.png?rev=2034417',
				'1x'  => 'https://ps.w.org/test_plugin/assets/icon.svg?rev=2034417',
				'svg' => 'https://ps.w.org/test_plugin/assets/icon.svg?rev=2034417',
			],
			'banners'        => [
				'2x' => 'https://ps.w.org/test_plugin/assets/banner-1544x500.png?rev=2034417',
				'1x' => 'https://ps.w.org/test_plugin/assets/banner-772x250.png?rev=2034417',
			],
			'banners_rtl'    => [],
			'is_beta'        => true,
			'upgrade_notice' => 'This is a beta update message.',
		],
	],
	'no_update' => [],
];

return [
	'testShouldReturnSameWhenOptinDisabled' => [
		'config'    => [
			'optin_enabled'   => false,
			'transient_trunk' => '1.1.0-beta',
		],
		'transient' => $transient,
		'expected'  => $transient,
	],
	'testShouldReturnSameWhenNoBetaVersion' => [
		'config'    => [
			'optin_enabled'   => true,
			'transient_trunk' => '1.0.0',
		],
		'transient' => $transient,
		'expected'  => $transient,
	],
	'testShouldReturnUpdatedTransient'      => [
		'config'    => [
			'optin_enabled'   => true,
			'transient_trunk' => '1.1.0-beta',
		],
		'transient' => $transient,
		'expected'  => $beta_transient,
	],
];
