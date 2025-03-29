<?php

namespace App\Http\Controllers\Api;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\OfficialPosition;
use App\Utilities\Debug;

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
		if (!Connection::impacted()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}
}