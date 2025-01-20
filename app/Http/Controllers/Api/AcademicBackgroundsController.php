<?php

namespace App\Http\Controllers\Api;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\AcademicBackground;
use App\Utilities\Debug;

class AcademicBackgroundsController extends Controller {
	private AcademicBackground $academic_background;
	private Request $request;

	public function __construct( Auth $auth, AcademicBackground $academic_background, Request $request) {
		parent::__construct( $auth );
		$this->academic_background = $academic_background;
		$this->request = $request;
	}

	public function delete():void {
		Debug::start('API ACADEMIC BACKGROUND DELETE');
		$id = $this->request->getParam('id');
		$response = ['error' => '', 'success' => ''];
		$this->academic_background->delete($id);
		if (!Connection::impactCheck()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}
}