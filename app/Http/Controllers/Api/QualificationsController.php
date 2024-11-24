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
		if (!$this->qualification->delete((int) $id)) {
			response()->json(['error' => 'User not found'], 404);
		}
		response()->json(['message' => 'User deleted']);
		Debug::end('API QUALIFICATION DELETE');
	}
}