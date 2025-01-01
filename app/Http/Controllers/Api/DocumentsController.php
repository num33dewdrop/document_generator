<?php

namespace Http\Controllers\Api;

use Auth\Auth;
use Database\Connection;
use Http\Controllers\Controller;
use Http\Requests\Request;
use Models\Document;
use Utilities\Debug;

class DocumentsController extends Controller {
	private Document $document;
	private Request $request;

	public function __construct( Auth $auth, Document $document, Request $request) {
		parent::__construct( $auth );
		$this->document = $document;
		$this->request = $request;
	}
	public function delete():void {
		Debug::start('API DOCUMENTS DELETE');
		$id = $this->request->getParam('id');
		$response = ['error' => '', 'success' => ''];
		$this->document->delete($id);
		if (!Connection::impactCheck()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}
}