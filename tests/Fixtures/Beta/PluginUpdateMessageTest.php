<?php

return [
	'testShouldDoNothingWhenBetaNotEnabled'   => [
		'status'   => false,
		'data'     => [
			'is_beta' => true,
		],
		'expected' => false,
	],
	'testShouldDoNothingWhenBetaNotAvailable' => [
		'status'   => true,
		'data'     => [
			'is_beta' => false,
		],
		'expected' => false,
	],
	'testShouldOutputBetaMessageWhenEnabled'  => [
		'status'   => true,
		'data'     => [
			'is_beta' => true,
		],
		'expected' => true,
	],
];
