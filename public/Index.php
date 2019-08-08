<?php
$path = explode("/", $_SERVER['REQUEST_URI']);
$controllerName = $path[1];
$actionName = $path[2];

$controllerFileName = ucfirst($controllerName);
include "..\App\Controller\\$controllerFileName.php";

$controllerObj = new Index();
$actionFuncName = $actionName . 'Action';

if(!method_exists($controllerObj, $actionFuncName)){
    echo "404";
    die;
}

$tpl = '../Templates/' . $controllerFileName . '/' . $actionName . '.phtml';

include "../Core/View.php";
$view123 = new View();
$controllerObj->view = $view123;
$controllerObj->$actionFuncName();


$view123->render($tpl);
