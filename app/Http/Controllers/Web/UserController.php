<?php

namespace App\Http\Controllers\Web;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Prefecture;
use App\Providers\FileServiceProvider;
use App\Utilities\Debug;

class UserController extends Controller {
	private Prefecture $prefecture;

	public function __construct( Auth $auth , Prefecture $prefecture) {
		parent::__construct( $auth );
		$this->prefecture = $prefecture;
	}

	public function edit() {
		Debug::start('USER EDIT');
		if (! $this->data["prefectures"] = $this->prefecture->all()) {
			redirect()->carry( [ 'error' => 'システムエラー発生' ] )->route( 'documents-list.show' );
		}
		// ビューにデータを渡して表示
		view('users.edit', $this->data, "edit");

		Debug::end('USER EDIT');
	}

	public function withdrawal() {
		Debug::start('USER WITHDRAWAL');
		// ビューにデータを渡して表示
		view('users.withdrawal', $this->data);

		Debug::end('USER WITHDRAWAL');
	}

	public function update(Request $request, FileServiceProvider $file_service_provider) {
		Debug::start('USER EDIT STORE');
		$rules = [
			'name' => 'required|string',
			'name_ruby' => 'string',
			'email' => 'required|email',
			'fixed_phone' => 'phone',
			'mobile_phone' => 'phone',
			'contact_phone' => 'phone',
			'zip' => 'zipcode',
			'contact_zip' => 'zipcode'
		];

		$request->setRules($rules);

		$request->validate();

		$file = $request->file('pic');
		$path = empty($file["name"])? null : $file_service_provider->upload($file);
		if(! $path) {
			$path = $request->input('db_pic') === ""? null: $request->input('db_pic');
		}
		$this->auth->user->update(array_merge($request->postAll(), ["pic" => $path]));

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('documents-list.show');
	}

	public function delete() {
		Debug::start('USER DELETE');
		$this->auth->user->delete();

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '削除に失敗しました。'])->back();
		}

		$this->auth->logout();

		redirect()->route('user-login.index');
	}
}