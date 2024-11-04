<?php

use Containers\Container;
use Http\Middleware\AuthMiddleware;
use Http\Middleware\GuestMiddleware;
use Http\Routes\Route;

//=================================================
//log設定
//=================================================
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/../log/php.log');

//=================================================
//ルーティングの初期化・ヘルパー関数・クラスの読み込み
//=================================================
require_once __DIR__ . '/../app/Session/Session.php';
require_once __DIR__ . '/../app/Utilities/Debug.php';
require_once __DIR__ . '/../app/Database/Connection.php';
require_once __DIR__ . '/../app/Validators/Validator.php';
require_once __DIR__ . '/../app/Http/Requests/Request.php';
require_once __DIR__ . '/../app/Http/Redirects/Redirect.php';
require_once __DIR__ . '/../app/Http/Routes/Route.php';
require_once __DIR__ . '/../app/Http/Middleware/MiddlewareInterface.php';
require_once __DIR__ . '/../app/Http/Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../app/Http/Middleware/GuestMiddleware.php';
require_once __DIR__ . '/../app/Containers/Container.php';
require_once __DIR__ . '/../app/Views/View.php';

require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Models/Qualification.php';

require_once __DIR__ . '/../app/Auth/Auth.php';
require_once __DIR__ . '/../app/Utilities/Paginator.php';

require_once __DIR__ . '/../app/Http/Controllers/Controller.php';
require_once __DIR__ . '/../app/Http/Controllers/DocumentsController.php';
require_once __DIR__ . '/../app/Http/Controllers/QualificationsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Auth/RegisterController.php';
require_once __DIR__ . '/../app/Http/Controllers/Auth/LoginController.php';

require_once __DIR__ . '/../app/helpers.php';

Route::registerMiddlewareAliases([
	'auth' => [AuthMiddleware::class],
	'guest' => [GuestMiddleware::class],
]);

require_once __DIR__ . '/../routes/web.php';

Route::handleRequest();