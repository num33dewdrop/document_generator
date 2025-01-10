<?php

namespace Http\Controllers\Web;

use Auth\Auth;
use Database\Connection;
use ErrorException;
use Exceptions\FileException;
use Http\Controllers\Controller;
use http\Exception\RuntimeException;
use Http\Requests\Request;
use Models\Prefecture;
use Providers\FileServiceProvider;
use Utilities\Debug;

class UserController extends Controller {
	private Prefecture $prefecture;

	public function __construct( Auth $auth , Prefecture $prefecture) {
		parent::__construct( $auth );
		$this->prefecture = $prefecture;
	}

	public function edit() {
		Debug::start('USER EDIT');
		$id = session()->get("user_id");
		if (! $data["user"] = $this->auth->user->findById($id)) {
			redirect()->carry( [ 'error' => '指定されたIDは存在しません' ] )->route( 'documents-list.show' );
		}
		if (! $data["prefectures"] = $this->prefecture->all()) {
			redirect()->carry( [ 'error' => 'システムエラー発生' ] )->route( 'documents-list.show' );
		}
		// ビューにデータを渡して表示
		view('users.edit', $data, "edit");

		Debug::end('USER EDIT');
	}

	public function update(Request $request, FileServiceProvider $file_service_provider) {
		Debug::start('USER EDIT STORE');
		$rules = [
			'user_name' => 'required|string',
			'email' => 'required'
		];

		$request->setRules($rules);

		$request->validate();

		$file = $request->file('pic');
		$path = empty($file["name"])? null : $file_service_provider->upload($file);
		if(! $path) {
			$path = $request->input('db_pic') === ""? null: $request->input('db_pic');
		}
		$this->auth->user->update(array_merge($request->postAll(), ["pic" => $path]));

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('documents-list.show');
	}
}