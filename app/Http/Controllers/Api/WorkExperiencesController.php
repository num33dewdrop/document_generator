<?php

namespace App\Http\Controllers\Api;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\WorkExperience;
use App\Utilities\Debug;

class WorkExperiencesController extends Controller {
	private WorkExperience $work_experience;
	private Request $request;

	public function __construct( Auth $auth, WorkExperience $work_experience, Request $request) {
		parent::__construct( $auth );
		$this->work_experience = $work_experience;
		$this->request = $request;
	}
	public function delete():void {
		Debug::start('API WORK EXPERIENCES DELETE');
		$id = $this->request->getParam('id');
		$response = ['error' => '', 'success' => ''];
		$this->work_experience->delete($id);
		if (!Connection::impactCheck()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}
}