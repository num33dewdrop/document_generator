<?php

namespace App\Http\Controllers\Outside;

use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Providers\GoogleServiceProvider;
use App\Utilities\Debug;
use Google\Service\Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Oauth2;
use Google_Service_Sheets;

class GoogleController extends Controller {
	public function login (GoogleServiceProvider $google_service_provider) {
		$client = $google_service_provider->setup(
			$this->config['google']['client_id'],
			$this->config['google']['secret'],
			base_domain().route('user-redirect.store'),
			$this->config['google']['scope']
		);
		if (!isset($_GET['code'])) {
			Debug::echo('Authorization code not received');
			redirect()->carry(['error' => 'Googleログインに失敗しました'])->route('user-login.index');
		}

		// 認証コードを使ってアクセストークンを取得
		$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
		$client->setAccessToken($token);

		// Googleのユーザー情報を取得
		$oauth = new Google_Service_Oauth2($client);
		try {
			$userInfo = $oauth->userinfo->get();
			$user = $this->auth->user->findByGoogleClient($userInfo->id);
			$id = $user['id']?? null;
			if(empty($id)) {
				$withdrawn = $this->auth->user->findByWithdrawnUser($userInfo->id);
				if(! empty($withdrawn)) {
					redirect()->carry(['error' => '退会ユーザーです。<br>再度ログインするには管理者に連絡をお願いします。'])->route('user-login.index');
				}
				$this->auth->user->create([
					'name' => $userInfo->name,
					'email' => $userInfo->email,
					'google_id' => $userInfo->id
				]);
				if (!Connection::impacted()) {
					redirect()->carry(['error' => '登録に失敗しました。'])->route('user-login.index');
				}
				$id = Connection::getPdo()->lastInsertId();
			}
			// 認証成功
			$sesLimit = 60 * 60;
			session()->put('login_date', time());
			session()->put('login_limit', $sesLimit);
			session()->put('user_id', $id);
			session()->put('google_token', $token);

			redirect()->route('documents-list.show');
		} catch ( Exception $e ) {
			Debug::echo('Authorization code not received'.$e->getMessage());
			redirect()->carry(['error' => 'Googleログインに失敗しました'])->route('user-login.index');
		}
	}
// verify
//	public function login (Request $request, GoogleServiceProvider $google_service_provider): void {
//		Debug::start('USER GOOGLE LOGIN');
//		$id_token = $request->input('credential');
//		$payload = $google_service_provider->verify($this->config['google']['client_id'], $id_token);
//
//		if ($payload) {
//			$googleId = $payload['sub']; // Googleの一意のID
//			$user = $this->auth->user->findByGoogleClient($googleId);
//			$id = $user['id']?? null;
//			if(empty($id)) {
//				$this->auth->user->create($payload);
//				if (!Connection::impacted()) {
//					redirect()->carry(['error' => '登録に失敗しました。'])->back();
//				}
//				$id = Connection::getPdo()->lastInsertId();
//			}
//			// 認証成功
//			$sesLimit = 60 * 60;
//			session()->put('login_date', time());
//			session()->put('login_limit', $sesLimit);
//			session()->put('user_id', $id);
//
//			redirect()->route('documents-list.show');
//		} else {
//			// トークンが無効な場合のエラー処理
//			Debug::echo('Invalid ID token.');
//			redirect()->carry(['error' => 'Googleログインに失敗しました'])->back();
//		}
//
//		Debug::end('USER GOOGLE LOGIN');
//	}


}