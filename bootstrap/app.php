<?php
//=================================================
//sessionの準備・sessionの有効期限を延ばす
//=================================================
//sessionの置き場の変更("/var/tmp/")に置くと30日は削除されない
session_save_path('/var/tmp/');
//ガーベージコレクションが削除するsessionの有効期限を設定
ini_set('session.gc_maxlifetime', 60*60*24*30);
//ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60*60*24*30);
//sessionを使う
session_start();
//現在のsessionIDを新しく生成したものに置き換える
session_regenerate_id();

//=================================================
//log設定
//=================================================
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/../log/php.log');

//=================================================
//ヘルパー関数・ルーティングの初期化・クラスの読み込み
//=================================================
require_once __DIR__ . '/../app/Utilities/Debug.php';
require_once __DIR__ . '/../app/Routes/Route.php';
require_once __DIR__ . '/../app/Views/View.php';

require_once __DIR__ . '/../app/Controllers/DocumentsController.php';

require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../routes/web.php';

