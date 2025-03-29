<?php

namespace App\Http\Controllers\Web;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\OfficialPosition;
use App\Models\WorkExperience;
use App\Utilities\Debug;

class OfficialPositionsController extends Controller {
	private WorkExperience $work_experience;
	private OfficialPosition $official_position;

	public function __construct( Auth $auth, WorkExperience $work_experience, OfficialPosition $official_position) {
		parent::__construct( $auth );
		$this->official_position = $official_position;
		$this->work_experience = $work_experience;
	}

	public function list($w_id): void {
		Debug::start('OFFICIAL POSITION LIST');
		if (! $this->data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		$this->data['official_positions'] = $this->official_position->list($w_id, 10);

		// ビューにデータを渡して表示
		view('official-positions.list', $this->data);
		Debug::end('OFFICIAL POSITION LIST');
	}

	public function register(string $w_id):void {
		Debug::start('OFFICIAL POSITION REGISTER');
		if (! $this->data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		// ビューにデータを渡して表示
		view('official-positions.form', $this->data, "register");
		Debug::end('OFFICIAL POSITION REGISTER');
	}

	public function edit(string $w_id, string $o_id):void {
		Debug::start('OFFICIAL POSITION EDIT');
		if (! $this->data["work_experience"] = $this->work_experience->findById($w_id)) {
			redirect()->carry(['error' => '指定された職歴IDは存在しません'])->route('work-experiences-list.show');
		}
		if (! $this->data["official_position"] = $this->official_position->findById($o_id)) {
			redirect()->carry(['error' => '指定された所属IDは存在しません'])->route('official-positions-list.show', ['w_id' => $w_id]);
		}
		// ビューにデータを渡して表示
		view('official-positions.form', $this->data, "edit");
		Debug::end('OFFICIAL POSITION EDIT');
	}

	public function create($w_id, Request $request):void {
		Debug::start('OFFICIAL POSITION REGISTER STORE');
		$rules = [
			'official_position_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
		];

		$request->setRules($rules);

		$request->validate();

		$this->official_position->create($w_id, $request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '登録に失敗しました。'])->back();
		}

		redirect()->route('official-positions-list.show', ['w_id' => $w_id]);
	}

	public function update(string $w_id, string $o_id, Request $request):void {
		Debug::start('OFFICIAL POSITION EDIT STORE');
		$rules = [
			'official_position_name' => 'required|string',
			'first_date' => 'required',
			'last_date' => 'required',
		];

		$request->setRules($rules);

		$request->validate();

		$this->official_position->update($o_id ,$request->postAll());

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('official-positions-list.show', ['w_id' => $w_id]);
	}

	public function delete(string $w_id, string $o_id):void {
		Debug::start('OFFICIAL POSITION DELETE');
		$this->official_position->delete($o_id);

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '編集に失敗しました。'])->back();
		}

		redirect()->route('official-positions-list.show', ['w_id' => $w_id]);
	}
}