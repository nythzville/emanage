<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => 'sk_test_7P7emvjQuarKfX2jBipqrNmt',
		'publishable' => 'pk_test_SbhXyrNoFLFSJjuZYvyOmJFr',
	],

	'facebook' => [
		'client_id'  => '1444746089151772', //1571648846407764
		'client_secret'  => 'b7e73e929b2672d194b4e214910b1caf', //c617e1edba9ce30de6584fd75bed9f0b
		'redirect' => 'http://www.raceit.hirepinoy.com/users/fbauth/auth', //http://www.raceit.hirepinoy.com/users/fbauth/auth
		'scope'   => "email, user_about_me, user_birthday, user_hometown, first_name, last_name", // optional
	],

	'google' => [
		'client_id'  => '150171266860-530n9s7ihvdg0kq4604d84e37f31mb7i.apps.googleusercontent.com',//870970124093-e8tprvqt1dpu3phunchfl6qu8aakfl10.apps.googleusercontent.com
		'client_secret'  => 'IaUkcsUYUMU-ilbjA1IdqsmV', //sZIEsG1xnYLrrvzK58bxAVTk
		'redirect' => 'http://www.raceit.hirepinoy.com/users/gauth/auth', //http://www.raceit.hirepinoy.com/users/gauth/auth
		'scope' => 'https://www.googleapis.com/auth/userinfo.email'
	],

];
