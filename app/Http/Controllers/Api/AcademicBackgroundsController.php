<?php

namespace Http\Controllers\Api;

use Auth\Auth;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\AcademicBackground;
use Utilities\Debug;

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
		if (!$this->academic_background->delete($id)) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 404);
		}
		$response['success'] ='削除に成功しました。';
		session()->flash('success', '削除に成功しました。');
		response()->json($response);
		Debug::end('API ACADEMIC BACKGROUND DELETE');
	}
}