<?php

namespace App\Http\Controllers\Api;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Qualification;
use App\Utilities\Debug;

class QualificationsController extends Controller {
	private Qualification $qualification;
	private Request $request;

	public function __construct( Auth $auth, Qualification $qualification, Request $request) {
		parent::__construct( $auth );
		$this->qualification = $qualification;
		$this->request = $request;
	}
	public function delete():void {
		Debug::start('API QUALIFICATION DELETE');
		$id = $this->request->getParam('id');
		$response = ['error' => '', 'success' => ''];
		$this->qualification->delete($id);
		if (!Connection::impacted()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}
}