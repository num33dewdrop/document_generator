<?php

namespace App\Http\Controllers\Web;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\AcademicBackground;
use App\Models\LastCareer;
use App\Utilities\Debug;

class AcademicBackgroundsController extends Controller {
	private AcademicBackground $academic_background;
	private LastCareer $last_career;

	public function __construct( Auth $auth, AcademicBackground $academic_background, LastCareer $last_career) {
		parent::__construct( $auth );
		$this->academic_background = $academic_background;
		$this->last_career = $last_career;
	}

	public function list(): void {
		Debug::start('ACADEMIC BACKGROUND LIST');
		$this->data["academic_backgrounds"] = $this->academic_background->list(10);
		// ビューにデータを渡して表示
		view('academic-backgrounds.list', $this->data);
		Debug::end('ACADEMIC BACKGROUND LIST');
	}

	public function register():void {
		Debug::start('ACADEMIC BACKGROUND REGISTER');
		if( ! $this->data["last_career"] = $this->last_career->all(0)) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('academic-backgrounds-list.show');
		}
		// ビューにデータを渡して表示
		view('academic-backgrounds.form', $this->data, "register");
		Debug::end('ACADEMIC BACKGROUND REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('ACADEMIC BACKGROUND EDIT');
		if (! $this->data["academic_background"] = $this->academic_background->findById($id)) {
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('academic-backgrounds-list.show');
		}
		if( ! $this->data["last_career"] = $this->last_career->all(0)) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('academic-backgrounds-list.show');
		}
		// ビューにデータを渡して表示
		view('academic-backgrounds.form', $this->data, "edit");
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

		$request->validate();

		$this->academic_background->create($request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '登録に失敗しました。'])->back();
		}

		redirect()->route('academic-backgrounds-list.show');
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

		$request->validate();

		$this->academic_background->update($id ,$request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('academic-backgrounds-list.show');
	}

	public function delete(string $id):void {
		Debug::start('ACADEMIC BACKGROUND DELETE');

		$this->academic_background->delete($id);

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '削除に失敗しました。'])->back();
		}

		redirect()->route('academic-backgrounds-list.show');
	}
}