<?php

namespace Http\Controllers;

use Auth\Auth;
use Http\Requests\Request;
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
		view('qualifications.qualification-list', $data);
		Debug::end('QUALIFICATION LIST');
	}

	public function register():void {
		Debug::start('QUALIFICATION REGISTER');
		// ビューにデータを渡して表示
		view('qualifications.qualification-register');
		session()->remove('errors');
		session()->remove('old');
		Debug::end('QUALIFICATION REGISTER');
	}

	public function edit(int $id):void {
		Debug::start('QUALIFICATION EDIT');
		$data = $this->qualification->findById($id);
		// ビューにデータを渡して表示
		view('qualifications.qualification-register', $data);
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

	public function update(int $id, Request $request):void {
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

	public function delete(int $id):void {
		Debug::start('QUALIFICATION DELETE');
		if (!$this->qualification->delete($id)) {
			redirect()->back();
		}
		redirect()->route('qualifications-list.show');
		Debug::end('QUALIFICATION DELETE');
	}
}