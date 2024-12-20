<?php

namespace Http\Controllers\Api;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\Qualification;
use Utilities\Debug;

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
		if (!$this->qualification->delete($id)) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 404);
		}
		$response['success'] ='削除に成功しました。';
		session()->flash('success', '削除に成功しました。');
		response()->json($response);
		Debug::end('API QUALIFICATION DELETE');
	}
}