<?php
use Http\Routes\Route;

//=================================================
//log設定
//=================================================
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/../log/php.log');

//=================================================
//ヘルパー関数・クラスの読み込み
//=================================================
require_once __DIR__ . '/../app/Session/Session.php';
require_once __DIR__ . '/../app/Utilities/Debug.php';
require_once __DIR__ . '/../app/Database/Connection.php';
require_once __DIR__ . '/../app/Validators/Validator.php';
require_once __DIR__ . '/../app/Http/Kernel.php';
require_once __DIR__ . '/../app/Http/Requests/Request.php';
require_once __DIR__ . '/../app/Http/Responses/Response.php';
require_once __DIR__ . '/../app/Http/Redirects/Redirect.php';
require_once __DIR__ . '/../app/Http/Routes/Route.php';
require_once __DIR__ . '/../app/Http/Middlewares/MiddlewareInterface.php';
require_once __DIR__ . '/../app/Http/Middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../app/Http/Middlewares/ApiCsrfMiddleware.php';
require_once __DIR__ . '/../app/Http/Middlewares/GuestMiddleware.php';
require_once __DIR__ . '/../app/Http/Middlewares/CsrfMiddleware.php';
require_once __DIR__ . '/../app/Providers/RouteServiceProvider.php';
require_once __DIR__ . '/../app/Containers/Container.php';
require_once __DIR__ . '/../app/Views/View.php';

require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Models/Qualification.php';
require_once __DIR__ . '/../app/Models/AcademicBackground.php';
require_once __DIR__ . '/../app/Models/WorkExperience.php';
require_once __DIR__ . '/../app/Models/Department.php';
require_once __DIR__ . '/../app/Models/OfficialPosition.php';
require_once __DIR__ . '/../app/Models/LastCareer.php';
require_once __DIR__ . '/../app/Models/EmploymentStatus.php';

require_once __DIR__ . '/../app/Auth/Auth.php';
require_once __DIR__ . '/../app/Utilities/Paginator.php';

require_once __DIR__ . '/../app/Http/Controllers/Controller.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/DocumentsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/QualificationsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/AcademicBackgroundsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/WorkExperiencesController.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/DepartmentsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/OfficialPositionsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/Auth/RegisterController.php';
require_once __DIR__ . '/../app/Http/Controllers/Web/Auth/LoginController.php';

require_once __DIR__ . '/../app/Http/Controllers/Api/QualificationsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Api/AcademicBackgroundsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Api/WorkExperiencesController.php';
require_once __DIR__ . '/../app/Http/Controllers/Api/DepartmentsController.php';
require_once __DIR__ . '/../app/Http/Controllers/Api/OfficialPositionsController.php';

require_once __DIR__ . '/../app/helpers.php';

//=================================================
//ルーティングの初期化
//=================================================
Route::handleRequest();