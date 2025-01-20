<?php

namespace App\Providers;

use RuntimeException;
use App\Utilities\Debug;

class FileServiceProvider {
	public function upload($file): string {
		Debug::echo( '画像アップロード処理開始' );
		Debug::echo( 'FILE情報：' . print_r( $file, true ) );
		try {
			if ( isset( $file['error'] ) && is_int( $file['error'] ) ) {
				//バリデーション
				//$file['error']には「UPLOAD_ERR_OK」などの定数が入っている
				//「UPLOAD_ERR_OK」などの定数はphpでファイルアップロード時に自動的に定義される。定数には値として0,1などの数値が入っている
				switch ( $file['error'] ) {
					case UPLOAD_ERR_OK:
						break;
					case UPLOAD_ERR_NO_FILE://未選択
						throw new RuntimeException( 'ファイルが選択されていません' );
					case UPLOAD_ERR_INI_SIZE://php.iniの定義サイズ超過
					case UPLOAD_ERR_FORM_SIZE://フォームの定義サイズ超過
						throw new RuntimeException( 'ファイルサイズが大きすぎます' );
					default://その他
						throw new RuntimeException( 'その他エラーが発生しました' );
				}

				//MIMEタイプチェック
				//$file['mime']は偽造可能なので、MIMEタイプは自前でチェック
				//exif_imagetype関数は「IMAGETYPE_JPEG」などの定数を返す
				//@をつけることでエラーが出ても後続処理が止まらない
				$type = @exif_imagetype( $file['tmp_name'] );
				if ( ! in_array( $type, [ IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG ], true ) ) {//trueで厳密チェック
					throw new RuntimeException( '画像形式が未対応です' );
				}
				//ファイルデータからsha1ハッシュをとってファイル名を決定、保存
				//ハッシュ化しておかないと同じファイル名がアップロードされる可能性があり、DBに保存しているパスがどちらかわからなくなる
				//image_type_to_extensionは拡張子を取得する関数
				$path = base_path( '/storage/app/public/uploads/' . sha1_file( $file['tmp_name'] ) . image_type_to_extension( $type ) );
				//ファイルの移動
				if ( ! move_uploaded_file( $file['tmp_name'], $path ) ) {
					throw new RuntimeException( 'ファイル保存時にエラーが発生しました' );
				}
				//保存したファイルパスのパーミッション（権限）を変更
				chmod( $path, 0644 );

				Debug::echo( 'ファイルは正常にアップロードされました' );
				Debug::echo( 'ファイルのpath：' . $path );

				return str_replace( $_SERVER['DOCUMENT_ROOT'], '', $path );
			}
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}

		return '';
	}
}