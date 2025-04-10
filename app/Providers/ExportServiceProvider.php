<?php

namespace App\Providers;

use App\Utilities\Debug;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Exception;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RuntimeException;

class ExportServiceProvider {
	private array $template;

	public function __construct () {
		$this->template = require base_path('config/template.php');
	}
	public function execution(array $data, $google_service_provider): void {
		$template_id = $this->template['google']['spreadsheet'];
		$accessToken = session()->get('google_token');
		$newId = $google_service_provider->generateResumeForUser($accessToken, $template_id, $data);
//		Debug::echo($newId);
	}
	// excelでの出力
//	public function execution(array $data): void {
//		// テンプレートのファイルパスを指定
//		$templatePath = base_path('/storage/app/templates/template_jis.xlsx');
//
//		// テンプレートを読み込み
//		$spreadsheet = IOFactory::load($templatePath);
//		$sheet = $spreadsheet->getActiveSheet();
//		$drawingCollection = $sheet->getDrawingCollection();
//		foreach ($drawingCollection as $key => $drawing) {
//			if (get_class($drawing) === 'PhpOffice\PhpSpreadsheet\Worksheet\Drawing') {
//				$drawingCollection->offsetUnset($key);
//			}
//		}
//
//		$sheet->setCellValue('B3', sanitize($data['user']['name_ruby']));
//		$sheet->setCellValue('B4', sanitize($data['user']['name']));
//		$sheet->setCellValue('B6', formatDateWithAge(sanitize($data['user']['birthday'])));
//		$sheet->setCellValue('B7', sanitize($data['user']['address_ruby']));
//		$sheet->setCellValue('A8', empty($data['user']['zip'])? "現住所（〒   -    ）" :"現住所（〒".sanitize($data['user']['zip'])."）");
//		$sheet->setCellValue('A9', sanitize($data['user']['prefecture']['name'].$data['user']['city_town_village']));
//		$sheet->setCellValue('B11', sanitize($data['user']['contact_address_ruby']));
//		$sheet->setCellValue('A12', empty($data['user']['contact_zip'])? "連絡先（〒   -    ）（現住所以外に連絡を希望する場合のみ記入）" :"連絡先（〒".sanitize($data['user']['contact_zip'])."）（現住所以外に連絡を希望する場合のみ記入）");
//		$sheet->setCellValue('A13', sanitize($data['user']['contact_prefecture']['name'].$data['user']['contact_city_town_village']));
//		$sheet->setCellValue('F7', "電話　".sanitize($data['user']['mobile_phone']));
//		$sheet->setCellValue('F9', sanitize($data['user']['email']));
//		$sheet->setCellValue('F11', "電話　".sanitize($data['user']['contact_phone']));
//		$sheet->setCellValue('F13', sanitize($data['user']['contact_email']));
//		if(isset($data['user']['sex'])) {
//			Debug::echo('性別');
//			$offsetX = $data['user']['sex'] === "0" ? 20 : 50;
//			$offsetY = 20;
//			$this->insertShape($sheet, $offsetX, $offsetY, 'E3');
//		}
//		if(isset($data['user']['partner'])) {
//			Debug::echo('配偶者');
//			$offsetX = $data['user']['partner'] === "0" ? 40 : 80;
//			$offsetY = 5;
//			$this->insertShape($sheet, $offsetX, $offsetY, 'L29');
//		}
//		if(isset($data['user']['partner_support'])) {
//			$offsetX = $data['user']['partner_support'] === "0" ? 40 : 80;
//			$offsetY = 5;
//			$this->insertShape($sheet, $offsetX, $offsetY, 'M29');
//		}
//
//		$writer = new Xlsx($spreadsheet);
//		// 出力用ファイル名
//		$filename = '履歴書_' . sanitize($data['user']['name']) . '.xlsx';
//
//		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//		header('Content-Disposition: attachment; filename="' . $filename . '"');
//		header('Cache-Control: max-age=0');
//
//		ob_clean(); // 不要な出力をクリア
//		try {
//			$writer->save( 'php://output' );
//		} catch ( Exception $e ) {
//			throw new RuntimeException($e);
//		}
//	}
//
//	// 丸の描画（性別選択）
//	private function insertShape ($sheet, $offsetX, $offsetY, $cell): void {
//		try {
//			// 丸の画像を挿入
//			$drawing = new Drawing();
//			$drawing->setPath(base_path('/storage/app/templates/circle.png')) // 丸の画像（透過PNG）
//				->setHeight(20) // 高さ
//				->setWidth(20)  // 幅
//				->setResizeProportional(false) // アスペクト比を維持するならfalse
//				->setCoordinates($cell) // 結合セルを指定
//				->setOffsetX($offsetX) // 左方向からの位置調整
//				->setOffsetY($offsetY) // 上方向からの位置調整
//				->setWorksheet( $sheet );
//		} catch ( Exception $e ) {
//			throw new RuntimeException($e);
//		}
//	}
}