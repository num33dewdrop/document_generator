<?php

namespace Http\Controllers\Api;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\WorkExperience;
use Utilities\Debug;

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
		if (!$this->work_experience->delete($id)) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 404);
		}
		$response['success'] ='削除に成功しました。';
		session()->flash('success', '削除に成功しました。');
		response()->json($response);
		Debug::end('API WORK EXPERIENCES DELETE');
	}
}