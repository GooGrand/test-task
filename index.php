<?php

session_start();

mb_internal_encoding("UTF-8");

function autoloadFunction($class)
{
    // Ends with a string "Controller"?
    if (preg_match('/Controller$/', $class))
        require("controllers/" . $class . ".php");
    else
        require("models/" . $class . ".php");
}
spl_autoload_register("autoloadFunction");

// Connects to the database
Db::connect("127.0.0.1", "root", "", "mvc_db");

//$utils = new Utils();
$userManager = new UserManager();
$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->renderView();