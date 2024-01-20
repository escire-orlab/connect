<?php

return [

	'user_class' => 'App\Models\User',

	'excel_view' => 'escireorlabconnect::excel.',

	'notification_via' => ['mail', 'database'],

	'export_disk' => 's3',

	'connect_key' => env('CONNECT_KEY', 'connect_key'),

	'connect_sites' => explode(',', env('CONNECT_SITES', '')),

	'redirect_path' => env('CONNECT_REDIRECT_PATH', 'dashboard'),
	
];