<?php

namespace Http\Controllers\Web;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\Department;
use Utilities\Debug;
use Validators\Validator;

class DepartmentsController extends Controller {
	private Department $department;

	public function __construct( Auth $auth, Department $department) {
		parent::__construct( $auth );
		$this->department = $department;
	}

	public function list(): void {
		Debug::start('DEPARTMENT LIST');
		$data = $this->department->list(10);
		// ビューにデータを渡して表示
		view('departments.list', $data);
		Debug::end('DEPARTMENT LIST');
	}

	public function register():void {
		Debug::start('DEPARTMENT REGISTER');
		// ビューにデータを渡して表示
		view('departments.form', [], "register");
		session()->remove('errors');
		session()->remove('old');
		Debug::end('DEPARTMENT REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('DEPARTMENT EDIT');
		if (! $data["department"] = $this->department->findById($id)) {
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('departments-list.show');
		}
		// ビューにデータを渡して表示
		view('departments.form', $data, "edit");
		session()->remove('errors');
		session()->remove('old');
		Debug::end('DEPARTMENT EDIT');
	}

	public function create(Request $request):void {
		Debug::start('DEPARTMENT REGISTER STORE');
		$rules = [
			'department_name' => 'required|string',
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

		if (!$this->department->create($request->postAll())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		redirect()->route('departments-list.show');
		Debug::end('DEPARTMENT REGISTER STORE');
	}

	public function update(string $id, Request $request):void {
		Debug::start('DEPARTMENT EDIT STORE');
		$rules = [
			'department_name' => 'required|string',
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

		if (!$this->department->update($id ,$request->postAll())) {
			redirect()->back();
		}

		session()->remove('errors');
		session()->remove('old');

		redirect()->route('departments-list.show');

		Debug::end('DEPARTMENT EDIT STORE');
	}

	public function delete(string $id):void {
		Debug::start('DEPARTMENT DELETE');
		if (!$this->department->delete($id)) {
			redirect()->back();
		}
		redirect()->route('departments-list.show');
		Debug::end('DEPARTMENT DELETE');
	}
}