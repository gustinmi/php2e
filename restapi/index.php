<?php

//********************************
// This is main application file. It's the onlyone that is aware of context (that is,
// if we are running the script from server environemnt or CLI environment).
// All other classes are free from context. They can be run from server, CLi, unittests.
// We map all requests to index.php, so this is central point (Front Controller).
// So far, the real REST uris are not supported, so we need to formulate query  with query strings (name of the controller and id of object)
//********************************

// Auto_load implementation, include commons
require('Bootstrap.php');

//support for commandline testing : pass required paramaters as CMD arguments

php_sapi_name() == 'cli' ? $handler = strtolower($argv[1]) : $handler = strtolower($_REQUEST['handler']);
php_sapi_name() == 'cli' ? $id = strtolower($argv[2]) : $id = strtolower($_REQUEST['id']);
php_sapi_name() == 'cli' ? $request_method = strtolower($argv[3]) : $request_method = strtolower($_SERVER['REQUEST_METHOD']);

//dispatcher

try {

    switch ($request_method){
        case 'get':
            $params = array('id' => $id);
            break;
        case 'put':
        case 'delete':
        case 'post':
            $raw = file_get_contents('php://input');  // get the raw http request body
            $params = json_decode($raw, true); // decode it into json array
            break;
        default:
            die("request method ${request_method} not supported");    
    }

    // get the php class name 
    $controllerName = '\\controllers\\' . ucfirst($handler);

    // create instance of class 
    $controller = new $controllerName();

    // execute appropriate method on controller instance
    $response = Call_User_Func(Array($controller, $request_method), $params);

    //if we are running this in server environment, render HTTP headers
    if (php_sapi_name() != 'cli')
        header("Content-Type: text/json; charset=utf-8");

    if (empty($response)) die("There was no response from database");
    else echo $response;

}catch(Exception $error){
    die($error);
}
