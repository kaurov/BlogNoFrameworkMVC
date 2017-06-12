<?php

// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';

//Application initialisation/entry point. 
if (isset($_GET['action']))
{
    // router 
    switch ($_GET['action'])
    {
        case 'about':
            $controller_name = 'IndexController';
            $action = 'aboutAction';
            break;
        
        case 'post':
            $controller_name = 'BlogController';
            $action = 'postAction';
            break;
        
        case 'addpost':
            $controller_name = 'BlogController';
            $action = 'addAction';
            break;
        
        case 'addpostsubmitted':
            $controller_name = 'BlogController';
            $action = 'addpostsubmittedAction';
            break;
        
        case 'addcomment':
            $controller_name = 'BlogController';
            $action = 'addcommentAction';
            break;
        
        case 'addcommentsubmitted':
            $controller_name = 'BlogController';
            $action = 'addcommentsubmittedAction';
            break;
        
        case 'login':
            $controller_name = 'IndexController';
            $action = 'loginAction';
            break;
        
        case 'loginsubmitted':
            $controller_name = 'IndexController';
            $action = 'loginsubmittedAction';
            break;
        
        case 'logout':
            $controller_name = 'IndexController';
            $action = 'logoutAction';
            break;

        case 'list':
        default:
            $controller_name = 'BlogController';
            $action = 'indexAction';
            break;
    }
} else
{
    $controller_name = 'BlogController';
    $action = 'indexAction';
}
require '../Application/Controller/' . $controller_name . '.php';

require '../Application/Model/BlogManager.php';
require '../Application/Model/UserManager.php';
require '../Application/View/Init.php';
$blogManager = new BlogManager($appConfig);
$userManager = new UserManager($appConfig);
$controller = new $controller_name($blogManager, $userManager);
$controller->{$action}($_REQUEST);

