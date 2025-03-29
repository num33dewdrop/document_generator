<?php
namespace App\Http\Controllers\Web;
use App\Auth\Auth;
use App\Database\Connection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\AcademicBackground;
use App\Models\AcademicBackgroundsDisplay;
use App\Models\Document;
use App\Models\Prefecture;
use App\Models\Qualification;
use App\Models\QualificationsDisplay;
use App\Models\WorkExperience;
use App\Models\WorkExperiencesDisplay;
use App\Providers\ExportServiceProvider;
use App\Providers\GoogleServiceProvider;
use PDOException;
use App\Utilities\Debug;
use ReflectionException;

class DocumentsController extends Controller {

	private Document $document;
	private AcademicBackground $academic_background;
	private WorkExperience $work_experience;
	private Qualification $qualification;
	private AcademicBackgroundsDisplay $academic_background_display;
	private WorkExperiencesDisplay $work_experience_display;
	private QualificationsDisplay $qualification_display;
	private Prefecture $prefecture;

	public function __construct(
		Auth $auth,
		Document $document,
		AcademicBackground $academic_background,
		WorkExperience $work_experience,
		Qualification $qualification,
		AcademicBackgroundsDisplay $academic_backgrounds_display,
		WorkExperiencesDisplay $work_experience_display,
		QualificationsDisplay $qualifications_display,
		Prefecture $prefecture
	)
	{
		parent::__construct( $auth );
		$this->document = $document;
		$this->academic_background = $academic_background;
		$this->work_experience = $work_experience;
		$this->qualification = $qualification;
		$this->academic_background_display = $academic_backgrounds_display;
		$this->work_experience_display = $work_experience_display;
		$this->qualification_display = $qualifications_display;
		$this->prefecture = $prefecture;
	}
	public function list(): void {
		Debug::start('DOCUMENT LIST');
		$this->data["documents"] = $this->document->list(10);
		// ビューにデータを渡して表示
		view('documents.list', $this->data);
		Debug::end('DOCUMENT LIST');
	}

	public function register():void {
		Debug::start('DOCUMENT REGISTER');
		if( ! $this->data["academic_background"] = $this->academic_background->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		if( ! $this->data["work_experience"] = $this->work_experience->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		if( ! $this->data["qualification"] = $this->qualification->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		// ビューにデータを渡して表示
		view('documents.form', $this->data, 'register');
		Debug::end('DOCUMENT REGISTER');
	}

	public function edit(string $id):void {
		Debug::start('DOCUMENT EDIT');
		if (! $this->data["document"] = $this->document->findById($id)) {
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('documents-list.show');
		}
		if( ! $this->data["academic_background"] = $this->academic_background->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		if( ! $this->data["work_experience"] = $this->work_experience->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		if( ! $this->data["qualification"] = $this->qualification->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		// ビューにデータを渡して表示
		view('documents.form', $this->data, 'edit');
		Debug::end('DOCUMENT EDIT');
	}

	public function copy(string $id):void {
		Debug::start('DOCUMENT COPY');
		if (! $this->data["document"] = $this->document->findById($id)) {
			redirect()->carry(['error' => '指定されたIDは存在しません'])->route('documents-list.show');
		}
		if( ! $this->data["academic_background"] = $this->academic_background->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		if( ! $this->data["work_experience"] = $this->work_experience->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		if( ! $this->data["qualification"] = $this->qualification->all()) {
			redirect()->carry(['error' => 'システムエラー発生'])->route('documents-list.show');
		}
		// ビューにデータを渡して表示
		view('documents.form', $this->data, 'copy');
		Debug::end('DOCUMENT COPY');
	}

	public function create(Request $request):void {
		Debug::start('DOCUMENT REGISTER STORE');
		$rules = [
			'document_name' => 'required|string',
		];
		$request->setRules($rules);

		$request->validate();
		try {
			Connection::beginTransaction();
			$this->document->create($request->postAll());
			$id = Connection::getPdo()->lastInsertId();
			foreach ($request->input('academic_background') as $key => $value) {
				$this->academic_background_display->create($id, $value);
			}
			foreach ($request->input('work_experience') as $key => $value) {
				$this->work_experience_display->create($id, $value);
			}
			foreach ($request->input('qualification') as $key => $value) {
				$this->qualification_display->create($id, $value);
			}
			Connection::commit();

			redirect()->route('documents-list.show');
		} catch(PDOException $e) {
			Connection::rollback();
			error_log('エラー : '.$e);
			redirect()->carry(['error' => "不正なデータが送信されました。"])->back();
		}
	}

	public function update(string $id, Request $request):void {
		Debug::start('DOCUMENT EDIT STORE');
		$rules = [
			'document_name' => 'required|string',
		];
		$request->setRules($rules);

		$request->validate();
		try {
			Connection::beginTransaction();
			$this->document->update($id, $request->postAll());

			$this->syncData(
				$id,
				$request->input('academic_background')?? [],
				"academic_background",
				[$this->academic_background_display, "all"],
				[$this->academic_background_display, "create"],
				[$this->academic_background_display, "remove"]
			);

			$this->syncData(
				$id,
				$request->input('work_experience')?? [],
				"work_experience",
				[$this->work_experience_display, "all"],
				[$this->work_experience_display, "create"],
				[$this->work_experience_display, "remove"]
			);

			$this->syncData(
				$id,
				$request->input('qualification')?? [],
				"qualification",
				[$this->qualification_display, "all"],
				[$this->qualification_display, "create"],
				[$this->qualification_display, "remove"]
			);

			Connection::commit();

			redirect()->route('documents-list.show');
		} catch(PDOException $e) {
			Connection::rollback();
			error_log('エラー : '.$e);
			redirect()->carry(['error' => "不正なデータが送信されました。"])->back();
		}
	}

	public function delete(string $id):void {
		Debug::start('DOCUMENT DELETE');
		$this->document->delete($id);

		if (!Connection::impacted()) {
			redirect()->carry(['error' => '削除に失敗しました。'])->back();
		}

		redirect()->route('documents-list.show');
	}

	public function export(
		string $id,
		ExportServiceProvider $export_service_provider,
		GoogleServiceProvider $google_service_provider
	):void {
		Debug::start('DOCUMENT EXPORT');
		if (! $data = $this->document->findById($id)) {
			redirect()->carry(['error' => '指定されたIDは存在しません'])->back();
		}
		$academicBackgroundIds = explode(',', $data['academic_backgrounds']);
		$workExperienceIds = explode(',', $data['work_experiences']);
		$qualificationIds = explode(',', $data['qualifications']);

		$data['academic_backgrounds'] = $this->academic_background->findByIds($academicBackgroundIds);
		$data['work_experiences'] = $this->work_experience->findByIds($workExperienceIds);
		$data['qualifications'] = $this->qualification->findByIds($qualificationIds);
		$data['user'] = $this->data['user'];
		$export_service_provider->execution($data, $google_service_provider);

		redirect()->route('documents-list.show');
		Debug::end('DOCUMENT EXPORT');
	}

	/**
	 * 表示データの同期メソッド
	 *
	 * @param string $d_id ドキュメントID
	 * @param array $requests 対象のリクエストの配列
	 * @param string $type データタイプ
	 * @param callable $fetchAll 関連データを取得するメソッド
	 * @param callable $create 関連データを作成するメソッド
	 * @param callable $remove 関連データを削除するメソッド
	 */
	private function syncData(
		string $d_id,
		array $requests,
		string $type,
		callable $fetchAll,
		callable $create,
		callable $remove
	):void {
		$data = call_user_func($fetchAll, $d_id);
		foreach ($data["records"] as $key => $value) {
			if (! in_array($value["{$type}_id"], $requests, true)) {
				call_user_func($remove, $d_id, $value["{$type}_id"]);
			}
		}
		foreach ($requests as $key => $value) {
			if (! in_array($value, array_column($data["records"] , "{$type}_id"), true)) {
				call_user_func($create, $d_id, $value);
			}
		}
	}
}