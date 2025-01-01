<?php

namespace Http\Controllers\Web;

use Auth\Auth;
use Database\Connection;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\EmploymentStatus;
use Models\LastCareer;
use Models\WorkExperience;
use Utilities\Debug;
use Validators\Validator;

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

		$data = $this->work_experience->list(10);
		// ビューにデータを渡して表示
		view('work-experiences.list', $data);

		Debug::end('WORK EXPERIENCES LIST');
	}

	public function register():void {
		Debug::start('WORK EXPERIENCES REGISTER');

		if( ! $data["last_career"] = $this->last_career->all(1)) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		if( ! $data["employment_status"] = $this->employment_status->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		// ビューにデータを渡して表示
		view('work-experiences.form', $data, "register");

		Debug::end('WORK EXPERIENCES REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('WORK EXPERIENCES EDIT');

		if (! $data["work_experiences"] = $this->work_experience->findById($id)) {
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('work-experiences-list.show');
		}
		if( ! $data["last_career"] = $this->last_career->all(1)) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		if( ! $data["employment_status"] = $this->employment_status->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('work-experiences-list.show');
		}
		// ビューにデータを渡して表示
		view('work-experiences.form', $data, "edit");

		Debug::end('WORK EXPERIENCES EDIT');
	}

	public function create(Request $request):void {
		Debug::start('WORK EXPERIENCES REGISTER STORE');

		$rules = [
			'company_name' => 'required|string',
			'business' => 'string',
			'capital_stock' => 'int',
			'sales' => 'int',
			'number_of_employees' => 'int',
			'employment_status' => 'int',
			'job_summary' => 'string',
			'last_career' => 'int',
			'experience' => 'string',
			'track_record' => 'string',
			'first_date' => 'required',
			'last_date' => 'required'
		];

		$request->setRules($rules);

		$request->validate();

		$this->work_experience->create($request->postAll());

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '登録に失敗しました。'])->back();
		}

		redirect()->route('work-experiences-list.show');
	}

	public function update(string $id, Request $request):void {
		Debug::start('WORK EXPERIENCES EDIT STORE');

		$rules = [
			'company_name' => 'required|string',
			'business' => 'string',
			'capital_stock' => 'int',
			'sales' => 'int',
			'number_of_employees' => 'int',
			'employment_status' => 'int',
			'job_summary' => 'string',
			'last_career' => 'int',
			'experience' => 'string',
			'track_record' => 'string',
			'first_date' => 'required',
			'last_date' => 'required'
		];

		$request->setRules($rules);

		$request->validate();

		$this->work_experience->update($id ,$request->postAll());

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('work-experiences-list.show');
	}

	public function delete(string $id):void {
		Debug::start('WORK EXPERIENCES DELETE');

		$this->work_experience->delete($id);

		if (!Connection::impactCheck()) {
			redirect()->carry(['error' => '削除に失敗しました。'])->back();
		}

		redirect()->route('work-experiences-list.show');
	}
}