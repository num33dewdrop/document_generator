<?php

namespace Http\Controllers\Web;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\Department;
use Models\WorkExperience;
use Utilities\Debug;
use Validators\Validator;

class DepartmentsController extends Controller {
	private Department $department;
	private WorkExperience $work_experience;

	public function __construct( Auth $auth, WorkExperience $work_experience, Department $department) {
		parent::__construct( $auth );
		$this->department = $department;
		$this->work_experience = $work_experience;
	}

	public function list($w_id): void {
		Debug::start('DEPARTMENT LIST');
		if (! $data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		$data['department'] = $this->department->list($w_id, 10);

		// ビューにデータを渡して表示
		view('departments.list', $data);
		Debug::end('DEPARTMENT LIST');
	}

	public function register(string $w_id):void {
		Debug::start('DEPARTMENT REGISTER');
		if (! $data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		// ビューにデータを渡して表示
		view('departments.form', $data, "register");
		Debug::end('DEPARTMENT REGISTER');
	}

	public function edit(string $w_id, string $d_id):void {
		Debug::start('DEPARTMENT EDIT');
		if (! $data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		if (! $data["department"] = $this->department->findById($d_id)) {
			redirect()->carry(['error' => '指定された所属IDは存在しません'])->route('departments-list.show', ['w_id' => $w_id]);
		}
		// ビューにデータを渡して表示
		view('departments.form', $data, "edit");
		Debug::end('DEPARTMENT EDIT');
	}

	public function create($w_id, Request $request):void {
		Debug::start('DEPARTMENT REGISTER STORE');
		$rules = [
			'department_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
		];

		$request->setRules($rules);

		$request->validate();

		$this->department->create($w_id, $request->postAll());

		redirect()->route('departments-list.show', ['w_id' => $w_id]);
		Debug::end('DEPARTMENT REGISTER STORE');
	}

	public function update(string $w_id, string $d_id, Request $request):void {
		Debug::start('DEPARTMENT EDIT STORE');
		$rules = [
			'department_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
		];

		$request->setRules($rules);

		$request->validate();

		$this->department->update($d_id ,$request->postAll());

		redirect()->route('departments-list.show', ['w_id' => $w_id]);

		Debug::end('DEPARTMENT EDIT STORE');
	}

	public function delete(string $w_id, string $d_id):void {
		Debug::start('DEPARTMENT DELETE');
		$this->department->delete($d_id);
		redirect()->route('departments-list.show', ['w_id' => $w_id]);
		Debug::end('DEPARTMENT DELETE');
	}
}