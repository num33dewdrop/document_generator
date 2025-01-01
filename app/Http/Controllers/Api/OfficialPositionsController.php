<?php

namespace Http\Controllers\Api;

use Auth\Auth;
use Database\Connection;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\OfficialPosition;
use Utilities\Debug;

class OfficialPositionsController extends Controller {
	private OfficialPosition $official_position;
	private Request $request;

	public function __construct( Auth $auth, OfficialPosition $official_position, Request $request) {
		parent::__construct( $auth );
		$this->official_position = $official_position;
		$this->request = $request;
	}

	public function delete():void {
		Debug::start('API OFFICIAL POSITION DELETE');
		$id = $this->request->getParam('id');
		$response = ['error' => '', 'success' => ''];
		$this->official_position->delete($id);
		if (!Connection::impactCheck()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}
}