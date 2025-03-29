<?php
return [
	'google' => [
		'client_id' => env('GOOGLE_CLIENT_ID'),
		'secret' => env('GOOGLE_CLIENT_SECRET'),
		'scope' => [
			'https://www.googleapis.com/auth/userinfo.profile',
			'https://www.googleapis.com/auth/userinfo.email',
			//			Google_Service_Drive::DRIVE,          // フルアクセス（最も強力）
			Google_Service_Drive::DRIVE_FILE,     // Drive のファイル編集権限
			Google_Service_Drive::DRIVE_READONLY, // Drive の読み取り権限
			Google_Service_Sheets::SPREADSHEETS   // Googleスプレッドシートの編集権限
		]
	],
	'errors' => [
		'failed' => 'ログインに失敗しました。入力内容をご確認の上、再度送信してください。',
	]
];