<?php
// get first part
// load controller
// invoke method
// send result
$url_parts = explode("/",  $_SERVER['PATH_INFO']);

$controllerName = $url_parts[1] . 'Controller';
function apiAutoload($controllerName)
{
    if (preg_match('/[a-zA-Z]+Controller$/', $controllerName)) {
        require __DIR__ . '/controllers/' . $controllerName . '.php';
        return true;
    } elseif (preg_match('/[a-zA-Z]+Model$/', $controllerName)) {
        include __DIR__ . '/models/' . $controllerName . '.php';
        return true;
    } elseif (preg_match('/[a-zA-Z]+View$/', $controllerName)) {
        include __DIR__ . '/views/' . $controllerName . '.php';
        return true;
    } else {
      return false;
    }
}
// $url_parts = array_shift($url_parts);
$className = $url_parts[1];
$apiLoaded = apiAutoload($controllerName);
if ($apiLoaded){
  if (class_exists($className)) {
    $ctrl = new $className();
    if (count($url_parts) >= 3) {
      $action = $url_parts[2];
      echo $ctrl->$action();
    } else {

      echo $ctrl->index();
    }
  } else {
    echo "no controller $className";
  }
} else {
  echo "didn't load controller";
  echo print_r($controllerName);
}
 ?>
