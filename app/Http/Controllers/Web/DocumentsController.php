<?php
namespace Http\Controllers\Web;
use Auth\Auth;
use Http\Controllers\Controller;
use Models\Document;
use Utilities\Debug;

class DocumentsController extends Controller {

	private Document $document;

	public function __construct( Auth $auth, Document $document) {
		parent::__construct( $auth );
		$this->document = $document;
	}
	public function list(): void {
		Debug::start('DOCUMENT LIST');
		$data = $this->document->list(10);
		// ビューにデータを渡して表示
		view('documents.list', $data);
		Debug::end('DOCUMENT LIST');
	}

	public function register():void {
		Debug::start('DOCUMENT REGISTER');
		// ビューにデータを渡して表示
		view('documents.form', [], 'register');
		Debug::end('DOCUMENT REGISTER');
	}

	public function edit(string $id):void {

		Debug::start('DOCUMENT EDIT');
		// ビューにデータを渡して表示
		view('documents.form', [], 'edit');
		Debug::end('DOCUMENT EDIT');
	}

	public function copy(string $id):void {
		Debug::start('DOCUMENT COPY');
		// ビューにデータを渡して表示
		view('documents.form', [], 'copy');
		Debug::end('DOCUMENT COPY');
	}

	public function create():void {
		Debug::start('DOCUMENT REGISTER STORE');

		Debug::end('DOCUMENT REGISTER STORE');
	}

	public function update():void {
		Debug::start('DOCUMENT EDIT STORE');

		Debug::end('DOCUMENT EDIT STORE');
	}

	public function delete():void {
		Debug::start('DOCUMENT DELETE');

		Debug::end('DOCUMENT DELETE');
	}

	public function export():void {
		Debug::start('DOCUMENT EXPORT');

		Debug::end('DOCUMENT EXPORT');
	}
}