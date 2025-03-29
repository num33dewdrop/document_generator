<?php

namespace App\Http\Controllers\Web;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\EmploymentStatus;
use App\Models\LastCareer;
use App\Models\WorkExperience;
use App\Utilities\Debug;

class WorkExperiencesController extends Controller  {
	private WorkExperience $work_experience;
	private LastCareer $last_career;
	private EmploymentStatus $employment_status;

	public function __construct( Auth $auth, WorkExperience $work_experience, LastCareer $last_career, EmploymentStatus $employment_status) {
		parent::__construct( $auth );
		$this->work_experience = $work_experience;
		$this->last_career = $last_career;
		$this->employment_status = $employment_status;
	}

	public function list(): void {
		Debug::start('WORK EXPERIENCES LIST');

		$this->data["work_experiences"] = $this->work_experience->list(10);
		// ビューにデータを渡して表示
		view('work-experiences.list', $this->data);

		Debug::end('WORK EXPERIENCES LIST');
	}

	public function register():void {
		Debug::start('WORK EXPERIENCES REGISTER');

		if( ! $this->data["last_career"] = $this->last_career->all(1)) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		if( ! $this->data["employment_status"] = $this->employment_status->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		// ビューにデータを渡して表示
		view('work-experiences.form', $this->data, "register");

		Debug::end('WORK EXPERIENCES REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('WORK EXPERIENCES EDIT');

		if (! $this->data["work_experiences"] = $this->work_experience->findById($id)) {
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('work-experiences-list.show');
		}
		if( ! $this->data["last_career"] = $this->last_career->all(1)) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		if( ! $this->data["employment_status"] = $this->employment_status->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		// ビューにデータを渡して表示
		view('work-experiences.form', $this->data, "edit");

		Debug::end('WORK EXPERIENCES EDIT');
	}

	public function create(Request $request):void {
		Debug::start('WORK EXPERIENCES REGISTER STORE');

		$rules = [
			'company_name' => 'required|string',
			'capital_stock' => 'int',
			'sales' => 'int',
			'number_of_employees' => 'int',
			'employment_status' => 'int',
			'last_career' => 'int',
			'first_date' => 'required',
			'last_date' => 'required'
		];

		$request->setRules($rules);

		$request->validate();

		$this->work_experience->create($request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '登録に失敗しました。'])->back();
		}

		redirect()->route('work-experiences-list.show');
	}

	public function update(string $id, Request $request):void {
		Debug::start('WORK EXPERIENCES EDIT STORE');

		$rules = [
			'company_name' => 'required|string',
			'capital_stock' => 'int',
			'sales' => 'int',
			'number_of_employees' => 'int',
			'employment_status' => 'int',
			'last_career' => 'int',
			'first_date' => 'required',
			'last_date' => 'required'
		];

		$request->setRules($rules);

		$request->validate();

		$this->work_experience->update($id ,$request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('work-experiences-list.show');
	}

	public function delete(string $id):void {
		Debug::start('WORK EXPERIENCES DELETE');

		$this->work_experience->delete($id);

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '削除に失敗しました。'])->back();
		}

		redirect()->route('work-experiences-list.show');
	}
}