<?php

namespace App\Http\Controllers\Api;

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
use App\Utilities\Debug;

class DocumentsController extends Controller {
	private Document $document;
	private Request $request;
	private AcademicBackground $academic_background;
	private WorkExperience $work_experience;
	private Qualification $qualification;
	private AcademicBackgroundsDisplay $academic_background_display;
	private WorkExperiencesDisplay $work_experience_display;
	private QualificationsDisplay $qualification_display;

	public function __construct(
		Auth $auth,
		Document $document,
		Request $request,
		AcademicBackground $academic_background,
		WorkExperience $work_experience,
		Qualification $qualification,
		AcademicBackgroundsDisplay $academic_backgrounds_display,
		WorkExperiencesDisplay $work_experience_display,
		QualificationsDisplay $qualifications_display
	) {
		parent::__construct( $auth );
		$this->document = $document;
		$this->request = $request;
		$this->academic_background = $academic_background;
		$this->work_experience = $work_experience;
		$this->qualification = $qualification;
		$this->academic_background_display = $academic_backgrounds_display;
		$this->work_experience_display = $work_experience_display;
		$this->qualification_display = $qualifications_display;
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

	public function export(
		ExportServiceProvider $export_service_provider,
		GoogleServiceProvider $google_service_provider
	):void {
		Debug::start('API DOCUMENT EXPORT');
		$id = $this->request->getParam('id');
		$response = ['error' => '', 'success' => ''];
		if (! $data = $this->document->findById($id)) {
			$response['error'] = '指定のIDが存在しません。';
			response()->json($response, 400);
		}

		$academicBackgroundIds = explode(',', $data['academic_backgrounds']);
		$workExperienceIds = explode(',', $data['work_experiences']);
		$qualificationIds = explode(',', $data['qualifications']);

		$data['academic_backgrounds'] = $this->academic_background->findByIds($academicBackgroundIds);
		$data['work_experiences'] = $this->work_experience->findByIds($workExperienceIds);
		$data['qualifications'] = $this->qualification->findByIds($qualificationIds);
		$data['user'] = $this->data['user'];
		$export_service_provider->execution($data, $google_service_provider);
		$response['success'] ='出力に成功しました。';
		response()->json($response);
		Debug::end('API DOCUMENT EXPORT');
	}
}