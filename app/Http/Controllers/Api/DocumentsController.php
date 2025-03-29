<?php

namespace App\Http\Controllers\Api;

use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Document;
use App\Utilities\Debug;

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
		if (!Connection::impacted()) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}
		$response['success'] ='削除に成功しました。';
		response()->json($response);
	}

	public function export():void {
		Debug::start('API DOCUMENT EXPORT');

		Debug::end('API DOCUMENT EXPORT');
	}
}