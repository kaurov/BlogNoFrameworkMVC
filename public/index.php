<?php
// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';

// the Application initialisation/entry point.
$routeAction = $_SERVER["REQUEST_URI"];
if (isset($_GET['action'])) {
    $routeAction = $_GET['action'];
}

// router
switch ($routeAction) {
    case '/about':
    case 'about':
        $controllerName = CmsController::class;
        $action = 'aboutAction';
        break;

    case 'post':
        $controllerName = 'BlogController';
        $action = 'postAction';
        break;

    case 'addpost':
        $controllerName = 'BlogController';
        $action = 'addAction';
        break;

    case 'addpostsubmitted':
        $controllerName = 'BlogController';
        $action = 'addpostsubmittedAction';
        break;

    case 'addcomment':
        $controllerName = 'BlogController';
        $action = 'addcommentAction';
        break;

    case 'addcommentsubmitted':
        $controllerName = 'BlogController';
        $action = 'addcommentsubmittedAction';
        break;

    case '/login':
    case 'login':
        $controllerName = AuthController::class;
        $action = 'loginAction';
        break;


    case '/loginsubmitted':
    case 'loginsubmitted':
        $controllerName = AuthController::class;
        $action = 'loginsubmittedAction';
        break;

    case '/logout':
    case 'logout':
        $controllerName = AuthController::class;
        $action = 'logoutAction';
        break;

    case 'list':
    default:
        $controllerName = 'BlogController';
        $action = 'indexAction';
        break;
}

require '../src/Controller/ControllerInterface.php';
require '../src/Controller/' . $controllerName . '.php';
require '../src/Model/DbConnectionManager.php';
require '../src/Model/BlogManager.php';
require '../src/Model/UserManager.php';
require '../src/View/BlogView.php';


$db = new DbConnectionManager($appConfig);
$dbConnection = null;
if ($db) {
    $dbConnection = $db->getConnection();
}
$blogManager = new BlogManager($dbConnection);
$userManager = new UserManager($dbConnection);

$controller = new $controllerName($blogManager, $userManager);
$controller->{$action}($_REQUEST);