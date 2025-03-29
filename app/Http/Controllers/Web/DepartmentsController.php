<?php

namespace App\Http\Controllers\Web;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Department;
use App\Models\WorkExperience;
use App\Utilities\Debug;

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
		if (! $this->data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		$this->data['departments'] = $this->department->list($w_id, 10);

		// ビューにデータを渡して表示
		view('departments.list', $this->data);
		Debug::end('DEPARTMENT LIST');
	}

	public function register(string $w_id):void {
		Debug::start('DEPARTMENT REGISTER');
		if (! $this->data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		// ビューにデータを渡して表示
		view('departments.form', $this->data, "register");
		Debug::end('DEPARTMENT REGISTER');
	}

	public function edit(string $w_id, string $d_id):void {
		Debug::start('DEPARTMENT EDIT');
		if (! $this->data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		if (! $this->data["department"] = $this->department->findById($d_id)) {
			redirect()->carry(['error' => '指定された所属IDは存在しません'])->route('departments-list.show', ['w_id' => $w_id]);
		}
		// ビューにデータを渡して表示
		view('departments.form', $this->data, "edit");
		Debug::end('DEPARTMENT EDIT');
	}

	public function create($w_id, Request $request):void {
		Debug::start('DEPARTMENT REGISTER STORE');
		$rules = [
			'department_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
			'scale' => 'required|int',
		];

		$request->setRules($rules);

		$request->validate();

		$this->department->create($w_id, $request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '登録に失敗しました。'])->back();
		}

		redirect()->route('departments-list.show', ['w_id' => $w_id]);
	}

	public function update(string $w_id, string $d_id, Request $request):void {
		Debug::start('DEPARTMENT EDIT STORE');
		$rules = [
			'department_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
			'scale' => 'required|int',
		];

		$request->setRules($rules);

		$request->validate();

		$this->department->update($d_id ,$request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('departments-list.show', ['w_id' => $w_id]);
	}

	public function delete(string $w_id, string $d_id):void {
		Debug::start('DEPARTMENT DELETE');
		$this->department->delete($d_id);

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '削除に失敗しました。'])->back();
		}

		redirect()->route('departments-list.show', ['w_id' => $w_id]);
	}
}