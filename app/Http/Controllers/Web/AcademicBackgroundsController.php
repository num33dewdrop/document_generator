<?php

namespace Http\Controllers\Web;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\AcademicBackground;
use Utilities\Debug;
use Validators\Validator;

class AcademicBackgroundsController extends Controller {
	private AcademicBackground $academic_background;

	public function __construct( Auth $auth, AcademicBackground $academic_background) {
		parent::__construct( $auth );
		$this->academic_background = $academic_background;
	}

	public function list(): void {
		Debug::start('ACADEMIC BACKGROUND LIST');
		$data = $this->academic_background->list(10);
		// ビューにデータを渡して表示
		view('academic-backgrounds.list', $data);
		Debug::end('ACADEMIC BACKGROUND LIST');
	}

	public function register():void {
		Debug::start('ACADEMIC BACKGROUND REGISTER');
		// ビューにデータを渡して表示
		view('academic-backgrounds.form');
		session()->remove('errors');
		session()->remove('old');
		Debug::end('ACADEMIC BACKGROUND REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('ACADEMIC BACKGROUND EDIT');
		if (! $data = $this->academic_background->findById($id)) {
			// ビューにデータを渡して表示
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('academic-backgrounds-list.show');
		}
		// ビューにデータを渡して表示
		view('academic-backgrounds.form', $data);
		session()->remove('errors');
		session()->remove('old');
		Debug::end('ACADEMIC BACKGROUND EDIT');
	}

	public function create(Request $request):void {
		Debug::start('ACADEMIC BACKGROUND REGISTER STORE');
		$rules = [
			'academic_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
			'last_career' => 'required',
		];

		$request->setRules($rules);

		if(!$request->validate()) {
			session()->put('errors', Validator::getErrors());
			session()->put('old', $request->postAll());
			redirect()->back();
			return;
		}

		if (!$this->academic_background->create($request->postAll())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		redirect()->route('academic-backgrounds-list.show');
		Debug::end('ACADEMIC BACKGROUND REGISTER STORE');
	}

	public function update(string $id, Request $request):void {
		Debug::start('ACADEMIC BACKGROUND EDIT STORE');
		$rules = [
			'academic_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
			'last_career' => 'required',
		];

		$request->setRules($rules);

		if(!$request->validate()) {
			session()->put('errors', Validator::getErrors());
			session()->put('old', $request->postAll());
			redirect()->back();
			return;
		}

		if (!$this->academic_background->update($id ,$request->postAll())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		redirect()->route('academic-backgrounds-list.show');

		Debug::end('ACADEMIC BACKGROUND EDIT STORE');
	}

	public function delete(string $id):void {
		Debug::start('ACADEMIC BACKGROUND DELETE');
		if (!$this->academic_background->delete($id)) {
			redirect()->back();
		}
		redirect()->route('academic-backgrounds-list.show');
		Debug::end('ACADEMIC BACKGROUND DELETE');
	}
}