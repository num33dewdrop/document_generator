<?php

namespace App\Http\Controllers\Web;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Qualification;
use App\Utilities\Debug;

class QualificationsController extends Controller {
	private Qualification $qualification;

	public function __construct( Auth $auth, Qualification $qualification) {
		parent::__construct( $auth );
		$this->qualification = $qualification;
	}

	public function list(): void {
		Debug::start('QUALIFICATION LIST');
		$this->data["qualifications"] = $this->qualification->list(10);
		// ビューにデータを渡して表示
		view('qualifications.list', $this->data);
		Debug::end('QUALIFICATION LIST');
	}

	public function register():void {
		Debug::start('QUALIFICATION REGISTER');
		// ビューにデータを渡して表示
		view('qualifications.form', $this->data, "register");
		Debug::end('QUALIFICATION REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('QUALIFICATION EDIT');
		if (! $this->data["qualification"] = $this->qualification->findById($id)) {
			// ビューにデータを渡して表示
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('qualifications-list.show');
		}
		// ビューにデータを渡して表示
		view('qualifications.form', $this->data, "edit");
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