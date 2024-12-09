<?php

namespace Http\Controllers\Web;

use Auth\Auth;
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
		session()->remove('errors');
		session()->remove('old');
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
		session()->remove('errors');
		session()->remove('old');
		Debug::end('QUALIFICATION EDIT');
	}

	public function create(Request $request):void {
		Debug::start('QUALIFICATION REGISTER STORE');
		$rules = [
			'qualification_name' => 'required|string|max:12',
			'acquisition_date' => 'required',
		];

		$request->setRules($rules);

		if(!$request->validate()) {
			session()->put('errors', Validator::getErrors());
			session()->put('old', $request->postAll());
			redirect()->back();
			return;
		}

		if (!$this->qualification->create($request->postAll())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		redirect()->route('qualifications-list.show');
		Debug::end('QUALIFICATION REGISTER STORE');
	}

	public function update(string $id, Request $request):void {
		Debug::start('QUALIFICATION EDIT STORE');
		$rules = [
			'qualification_name' => 'required|string|max:12',
			'acquisition_date' => 'required',
		];

		$request->setRules($rules);

		if(!$request->validate()) {
			session()->put('errors', Validator::getErrors());
			session()->put('old', $request->postAll());
			redirect()->back();
			return;
		}

		if (!$this->qualification->update($id ,$request->postAll())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		redirect()->route('qualifications-list.show');

		Debug::end('QUALIFICATION EDIT STORE');
	}

	public function delete(string $id):void {
		Debug::start('QUALIFICATION DELETE');
		if (!$this->qualification->delete($id)) {
			redirect()->back();
		}
		redirect()->route('qualifications-list.show');
		Debug::end('QUALIFICATION DELETE');
	}
}