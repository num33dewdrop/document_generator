<?php

namespace Http\Controllers\Web;

use Auth\Auth;
use Database\Connection;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Http\Routes\Route;
use Models\Qualification;
use Utilities\Debug;
use Validators\Validator;

class QualificationsController extends Controller {
	private Qualification $qualification;

	public function __construct( Auth $auth, Qualification $qualification) {
		parent::__construct( $auth );
		$this->qualification = $qualification;
	}

	public function list(): void {
		Debug::start('QUALIFICATION LIST');
		$data = $this->qualification->list(10);
		// ビューにデータを渡して表示
		view('qualifications.list', $data);
		Debug::end('QUALIFICATION LIST');
	}

	public function register():void {
		Debug::start('QUALIFICATION REGISTER');
		// ビューにデータを渡して表示
		view('qualifications.form', [], "register");
		Debug::end('QUALIFICATION REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('QUALIFICATION EDIT');
		if (! $data["qualification"] = $this->qualification->findById($id)) {
			// ビューにデータを渡して表示
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('qualifications-list.show');
		}
		// ビューにデータを渡して表示
		view('qualifications.form', $data, "edit");
		Debug::end('QUALIFICATION EDIT');
	}

	public function create(Request $request):void {
		Debug::start('QUALIFICATION REGISTER STORE');
		$rules = [
			'qualification_name' => 'required|string|max:12',
			'acquisition_date' => 'required',
		];

		$request->setRules($rules);

		$request->validate();

		$this->qualification->create($request->postAll());

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '登録に失敗しました。'])->back();
		}

		redirect()->carry(['success' => '資格を登録しました。'])->route('qualifications-list.show');
	}

	public function update(string $id, Request $request):void {
		Debug::start('QUALIFICATION EDIT STORE');
		$rules = [
			'qualification_name' => 'required|string|max:12',
			'acquisition_date' => 'required',
		];

		$request->setRules($rules);

		$request->validate();

		$this->qualification->update($id ,$request->postAll());

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('qualifications-list.show');
	}

	public function delete(string $id):void {
		Debug::start('QUALIFICATION DELETE');
		$this->qualification->delete($id);

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '削除に失敗しました。'])->back();
		}

		redirect()->route('qualifications-list.show');
	}
}