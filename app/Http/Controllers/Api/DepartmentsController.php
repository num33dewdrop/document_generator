<?php

namespace App\Http\Controllers\Api;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Department;
use App\Utilities\Debug;

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
		$this->department->delete($id);
		if (!Connection::impacted()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}
}