<?php

namespace Http\Controllers\Api;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\Department;
use Utilities\Debug;

class DepartmentsController extends Controller {
	private Department $department;
	private Request $request;

	public function __construct( Auth $auth, Department $department, Request $request) {
		parent::__construct( $auth );
		$this->department = $department;
		$this->request = $request;
	}

	public function delete():void {
		Debug::start('API DEPARTMENT DELETE');
		$id = $this->request->getParam('id');
		$response = ['error' => '', 'success' => ''];
		if (!$this->department->delete($id)) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 404);
		}
		$response['success'] ='削除に成功しました。';
		session()->flash('success', '削除に成功しました。');
		response()->json($response);
		Debug::end('API DEPARTMENT DELETE');
	}
}