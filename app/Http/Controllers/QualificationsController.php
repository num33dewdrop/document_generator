<?php

namespace Http\Controllers;

use Http\Requests\Request;
use Models\Qualification;
use Utilities\Debug;
use Validators\Validator;

class QualificationsController extends Controller {
	public function list(Qualification $qualification): void {
		Debug::start('QUALIFICATION LIST');
		$this->data['head']['title'] = 'QUALIFICATION LIST';
		$this->data['head']['description'] = 'QUALIFICATION LISTの説明';
		$this->data['list'] = $qualification->list();
		// ビューにデータを渡して表示
		view('qualifications.qualification-list', $this->data);
		Debug::end('QUALIFICATION LIST');
	}

	public function register():void {
		Debug::start('QUALIFICATION REGISTER');
		$this->data['head']['title'] = 'QUALIFICATION REGISTER';
		$this->data['head']['description'] = 'QUALIFICATION REGISTERの説明';
		// ビューにデータを渡して表示
		view('qualifications.qualification-register', $this->data);
		session()->remove('errors');
		session()->remove('old');
		Debug::end('QUALIFICATION REGISTER');
	}

	public function edit():void {
		Debug::start('QUALIFICATION EDIT');
		$this->data['head']['title'] = 'QUALIFICATION EDIT';
		$this->data['head']['description'] = 'QUALIFICATION EDITの説明';
		// ビューにデータを渡して表示
		view('qualifications.qualification-register', $this->data);
		session()->remove('errors');
		session()->remove('old');
		Debug::end('QUALIFICATION EDIT');
	}

	public function create(Request $request, Qualification $qualification):void {
		Debug::start('QUALIFICATION REGISTER STORE');
		$rules = [
			'qualification_name' => 'required|string|max:12',
			'acquisition_date' => 'required',
		];

		$request->setRules($rules);

		if(!$request->validate()) {
			session()->put('errors', Validator::getErrors());
			session()->put('old', $request->all());
			redirect()->back();
			return;
		}

		if (!$qualification->create($request->all())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		redirect()->route('qualifications-list.show');
		Debug::end('QUALIFICATION REGISTER STORE');
	}

	public function update():void {
		Debug::start('QUALIFICATION EDIT STORE');

		Debug::end('QUALIFICATION EDIT STORE');
	}

	public function delete():void {
		Debug::start('QUALIFICATION DELETE');

		Debug::end('QUALIFICATION DELETE');
	}
}