<?php

namespace App\Providers;

use App\Utilities\Debug;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_Request;
use Google_Service_Sheets_ValueRange;

class GoogleServiceProvider {
	public function setup (string $client_id, string $secret, string $redirect, array $scope) : Google_Client {
		$client = new Google_Client();

		$client->setClientId($client_id);
		$client->setClientSecret($secret);
		$client->setRedirectUri($redirect);
		$client->addScope($scope);
		return $client;
	}

	public function redirectToGoogle ( $client) : void {
		$authUrl = $client->createAuthUrl();
		header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
		exit;
	}
	public function copyTemplateToUserDrive($accessToken, $templateFileId): string {
		$client = new Google_Client();
		$client->setAccessToken($accessToken); // ユーザーのアクセストークンをセット

		$driveService = new Google_Service_Drive($client);

		// 新しいスプレッドシートの情報を設定
		$fileMetadata = new Google_Service_Drive_DriveFile([
			'name' => '履歴書_' . date('Ymd_His') . '.xlsx',
			'mimeType' => 'application/vnd.google-apps.spreadsheet',
			'parents' => ['root'] // マイドライブ直下に保存
		]);

		// テンプレートをコピー
		$newFile = $driveService->files->copy($templateFileId, $fileMetadata);

		// 作成されたスプレッドシートのIDを返す
		return $newFile->id;
	}
	public function fillSpreadsheetWithData($accessToken, $spreadsheetId, $documentData): void {
		$client = new Google_Client();
		$client->setAccessToken($accessToken); // ユーザーのアクセストークンをセット
		$sheetsService = new Google_Service_Sheets($client);

		// スプレッドシートの情報を取得
		$spreadsheet = $sheetsService->spreadsheets->get($spreadsheetId);

		// シート名の一覧を取得
		$sheets = $spreadsheet->getSheets();
		$sheetNames = [];

		foreach ($sheets as $sheet) {
			$sheetNames[] = $sheet->getProperties()->getTitle(); // シート名を取得
		}

		// 最初のシート名を取得（例: 複数ある場合は最初のシートを使う）
		$sheetName = $sheetNames[0] ?? null;
		$range = "{$sheetName}!B2:S57";

		// 既存データを取得
		$response = $sheetsService->spreadsheets_values->get($spreadsheetId, $range);
		$expectedColumnCount = 18;
		$expectedRowCount = 53;

		$existingData = array_map(function ($row) use ($expectedColumnCount) {
			return array_replace(array_fill(0, $expectedColumnCount, ''), $row);
		}, $response->getValues());

		// 行数を揃える（足りない分だけ空行を追加）
		$currentRowCount = count($existingData);
		if ($currentRowCount < $expectedRowCount) {
			$emptyRow = array_fill(0, $expectedColumnCount, '');
			for ($i = $currentRowCount; $i < $expectedRowCount; $i++) {
				$existingData[] = $emptyRow;
			}
		}

		Debug::echo($documentData);
		// 必要なセルだけ更新
		$existingData[0][3] = date('Y年m月d日現在');
//		if(isset($documentData["user"]["pic"])){
//			$existingData[0][6] = '=IMAGE("' . $documentData["user"]["pic"] . '")';
//		}
		$existingData[2][1] = $documentData["user"]["name_ruby"]?? "";
		$existingData[4][1] = $documentData["user"]["name"];
		$existingData[7][0] = formatDateWithAge(sanitize($documentData['user']['birthday']));
		$existingData[8][4] = $documentData["user"]["sex"]?? "";
		$existingData[9][1] = $documentData["user"]["address_ruby"]?? ""; //住所フリガナ入力欄忘れ。後で追加
		$existingData[11][2] = $documentData["user"]["zip"]?? "";
		$existingData[13][0] = isset($documentData["user"]["prefecture"])?
			$documentData["user"]["prefecture"].$documentData["user"]["city_town_village"]:
			"";
		$existingData[15][1] = $documentData["user"]["contact_address_ruby"]?? ""; //連絡先住所フリガナ入力欄忘れ。後で追加
		$existingData[17][2] = $documentData["user"]["contact_zip"]?? "";
		$existingData[18][1] = isset($documentData["user"]["contact_prefecture"])?
			$documentData["user"]["contact_prefecture"].$documentData["user"]["contact_city_town_village"]:
			"";
		$existingData[9][7] = $documentData["user"]["mobile_phone"]?? "";
		$existingData[13][6] = $documentData["user"]["email"];
		$existingData[15][7] = $documentData["user"]["contact_phone"]?? "";
		$existingData[19][6] = $documentData["user"]["contact_email"]?? "";

		// 学歴・職歴トータル
		$ab_total = $documentData["academic_backgrounds"]["total"];
		$we_total = $documentData["work_experiences"]["total"];
		// 学歴
		if(count($documentData["academic_backgrounds"]["records"]) > 0) {
			$existingData[24][2] = "学歴";
			// 学科名のカラム足りない。後で追加
			foreach ($documentData["academic_backgrounds"]["records"] as $key => $value) {
				$start_date = explode('-', $value["first_date"]);
				$last_date = explode('-', $value["last_date"]);
				if($key < 7) {
					$existingData[26 + ($key * 4)][0] = $start_date[0];
					$existingData[26 + ($key * 4)][1] = $start_date[1];
					$existingData[26 + ($key * 4)][2] = $value["name"].'　入学';
					$existingData[26 + ($key * 4) + 2][0] = $last_date[0];
					$existingData[26 + ($key * 4) + 2][1] = $last_date[1];
					$existingData[26 + ($key * 4) + 2][2] = $value["name"].'　'.$value["last_career"];
				} else {
					$existingData[2 + (($key - 7) * 4)][11] = $start_date[0];
					$existingData[2 + (($key - 7) * 4)][12] = $start_date[1];
					$existingData[2 + (($key - 7) * 4)][13] = $value["name"].'　入学';
					$existingData[2 + (($key - 7) * 4) + 2][11] = $last_date[0];
					$existingData[2 + (($key - 7) * 4) + 2][12] = $last_date[1];
					$existingData[2 + (($key - 7) * 4) + 2][13] = $value["name"].'　'.$value["last_career"];
				}
			}
		}

		// 職歴
		if(count($documentData["work_experiences"]["records"]) > 0) {
			if($ab_total <= 5) {
				$existingData[26 + ($ab_total * 4) + 2][2] = "職歴";
			} else {
				$existingData[2 + (max(($ab_total - 7), 0) * 4) + 2][13] = "職歴";
			}

			foreach ($documentData["work_experiences"]["records"] as $key => $value) {
				$start_date = explode('-', $value["first_date"]);
				$last_date = explode('-', $value["last_date"]);
				if($ab_total <= 5) {
					if($ab_total + $key <= 4) {
						$existingData[26 + ($ab_total * 4) + ($key * 4) + 4][0] = $start_date[0];
						$existingData[26 + ($ab_total * 4) + ($key * 4) + 4][1] = $start_date[1];
						$existingData[26 + ($ab_total * 4) + ($key * 4) + 4][2] = $value["name"].'　入社';
						$existingData[26 + ($ab_total * 4) + ($key * 4) + 6][0] = $last_date[0];
						$existingData[26 + ($ab_total * 4) + ($key * 4) + 6][1] = $last_date[1];
						$existingData[26 + ($ab_total * 4) + ($key * 4) + 6][2] = $value["name"].'　'.$value["last_career"];
					} else {
						$existingData[2 + (max(($ab_total - 7), 0) * 4) + (($key - (5 - $ab_total)) * 4)][11] = $start_date[0];
						$existingData[2 + (max(($ab_total - 7), 0) * 4) + (($key - (5 - $ab_total)) * 4)][12] = $start_date[1];
						$existingData[2 + (max(($ab_total - 7), 0) * 4) + (($key - (5 - $ab_total)) * 4)][13] = $value["name"].'　入社';
						$existingData[2 + (max(($ab_total - 7), 0) * 4) + (($key - (5 - $ab_total)) * 4) + 2][11] = $last_date[0];
						$existingData[2 + (max(($ab_total - 7), 0) * 4) + (($key - (5 - $ab_total)) * 4) + 2][12] = $last_date[1];
						$existingData[2 + (max(($ab_total - 7), 0) * 4) + (($key - (5 - $ab_total)) * 4) + 2][13] = $value["name"].'　'.$value["last_career"];
					}
				} else {
					$existingData[2 + (max(($ab_total - 7), 0) * 4) + ($key * 4) + (max(($ab_total - 7), 0) === 0? 2:4)][11] = $start_date[0];
					$existingData[2 + (max(($ab_total - 7), 0) * 4) + ($key * 4) + (max(($ab_total - 7), 0) === 0? 2:4)][12] = $start_date[1];
					$existingData[2 + (max(($ab_total - 7), 0) * 4) + ($key * 4) + (max(($ab_total - 7), 0) === 0? 2:4)][13] = $value["name"].'　入社';
					$existingData[2 + (max(($ab_total - 7), 0) * 4) + ($key * 4) + (max(($ab_total - 7), 0) === 0? 4:6)][11] = $last_date[0];
					$existingData[2 + (max(($ab_total - 7), 0) * 4) + ($key * 4) + (max(($ab_total - 7), 0) === 0? 4:6)][12] = $last_date[1];
					$existingData[2 + (max(($ab_total - 7), 0) * 4) + ($key * 4) + (max(($ab_total - 7), 0) === 0? 4:6)][13] = $value["name"].'　'.$value["last_career"];
				}
			}
		}

		if($ab_total + $we_total <= 5) {
			$existingData[26 + ($ab_total * 4) + ($we_total * 4) + 4][2] = "現在に至る";
			$existingData[26 + ($ab_total * 4) + ($we_total * 4) + 6][2] = "以上"; //これを右寄せにしたい
		} else {
			$existingData[2 + (($ab_total + $we_total - 5) * 4)][13] = "現在に至る";
			$existingData[2 + (($ab_total + $we_total - 5) * 4) + 2][13] = "以上"; //これを右寄せにしたい
		}

		// 資格
		foreach ($documentData["qualifications"]["records"] as $key => $value) {
			$acquisition_date = explode('-', $value["acquisition_date"]);
			$existingData[17 + ($key * 2)][11] = $acquisition_date[0];
			$existingData[17 + ($key * 2)][12] = $acquisition_date[1];
			$existingData[17 + ($key * 2)][13] = $value["name"];
		}

		// 志望動機・自己PR
		$existingData[32][11] = $documentData["pr"]?? "";

		// 本人希望欄
		$existingData[46][11] = $documentData["wish"]?? "";

		// 通勤時間（約　時間　分）

		// 扶養家族人数
		$existingData[37][16] = ($documentData["dependents"]?? "")."人";

		// 配偶者
		$existingData[41][16] = $documentData["user"]["partner"] === 1? "有":"無";
		$existingData[41][17] = $documentData["user"]["partner_support"] === 1? "有":"無";

		// 更新リクエスト
		$valueRange = new Google_Service_Sheets_ValueRange();
		$valueRange->setValues($existingData);
		$valueRange->setMajorDimension("ROWS");
		$params = ['valueInputOption' => 'USER_ENTERED'];
		$sheetsService->spreadsheets_values->update($spreadsheetId, $range, $valueRange, $params);

		// フォーマット設定リクエスト
		$requests = [
			new Google_Service_Sheets_Request([
				"repeatCell" => [
					"range" => [
						"sheetId" => $sheets[0]->getProperties()->getSheetId(),
						"startRowIndex" => 25, //行の開始位置
						"endRowIndex" => 27, //行の終了位置
						"startColumnIndex" => 3, // 列の開始位置
						"endColumnIndex" => 4 // 列の終了位置
					],
					"cell" => [
						"userEnteredFormat" => [
							"horizontalAlignment" => "CENTER",
							"textFormat" => [
								"fontSize" => 11, // 文字サイズを明示的に設定
								"bold" => false
							],
							"numberFormat" => [
								"type" => "TEXT", // 数値ではなくテキストとして扱う
							]
						]
					],
					"fields" => "userEnteredFormat.horizontalAlignment,userEnteredFormat.textFormat,userEnteredFormat.numberFormat"
				]
			]),
			new Google_Service_Sheets_Request([
				"repeatCell" => [
					"range" => [
						"sheetId" => $sheets[0]->getProperties()->getSheetId(),
						"startRowIndex" => $ab_total < 7 ? 25 + ($ab_total * 4) + 4: 3 + (($ab_total - 7) * 4),
						"endRowIndex" => $ab_total < 7 ? 27 + ($ab_total * 4) + 4: 5 + (($ab_total - 7) * 4),
						"startColumnIndex" => $ab_total < 7 ? 3: 14,
						"endColumnIndex" => $ab_total < 7 ?4: 15
					],
					"cell" => [
						"userEnteredFormat" => [
							"horizontalAlignment" => "CENTER",
							"textFormat" => [
								"fontSize" => 11,
								"bold" => false
							],
							"numberFormat" => [
								"type" => "TEXT"
							]
						]
					],
					"fields" => "userEnteredFormat.horizontalAlignment,userEnteredFormat.textFormat,userEnteredFormat.numberFormat"
				]
			]),
			new Google_Service_Sheets_Request([
				"repeatCell" => [
					"range" => [
						"sheetId" => $sheets[0]->getProperties()->getSheetId(),
						"startRowIndex" => $ab_total + $we_total <= 5? 25 + ($ab_total * 4) + ($we_total * 4) + 8: 3 + (($ab_total + $we_total - 5) * 4) + 2,
						"endRowIndex" => $ab_total + $we_total <= 5? 27 + ($ab_total * 4) + ($we_total * 4) + 8:5 + (($ab_total + $we_total - 5) * 4) + 2,
						"startColumnIndex" => $ab_total + $we_total <= 5? 3: 14,
						"endColumnIndex" => $ab_total + $we_total <= 5?4: 15
					],
					"cell" => [
						"userEnteredFormat" => [
							"horizontalAlignment" => "RIGHT",
							"textFormat" => [
								"fontSize" => 11,
								"bold" => false
							],
							"numberFormat" => [
								"type" => "TEXT"
							]
						]
					],
					"fields" => "userEnteredFormat.horizontalAlignment,userEnteredFormat.textFormat,userEnteredFormat.numberFormat"
				]
			])
		];
		// リクエストを送信
		$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
			"requests" => $requests
		]);
		$sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
	}
	public function generateResumeForUser($accessToken, $templateFileId, $documentData): string {
		// ① ユーザーのDriveにコピー
		$spreadsheetId = $this->copyTemplateToUserDrive($accessToken, $templateFileId);

		// ② ユーザー情報をシートに埋め込む
		$this->fillSpreadsheetWithData($accessToken, $spreadsheetId, $documentData);

		// ③ ユーザーにURLを返す
		return "https://docs.google.com/spreadsheets/d/$spreadsheetId/edit";
	}
	public function verify (string $client_id, string $token) : array {
		$client = new Google_Client( [ 'client_id' => $client_id ] );
		return $client->verifyIdToken( $token );
	}
}