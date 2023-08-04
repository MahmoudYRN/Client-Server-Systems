<?php
require_once('Models/userData.php');
require_once('Models/userDataSet.php');
require_once('Models/user.php');

$view = new stdClass();
$view->pageTitle = 'Register user';

$userData = new userDataSet();

$view->dbMessage ="";
$view->loginError = false;

//session_start();
$user = new user();
//var_dump($_SESSION);

if (isset($_POST["login-btn"])) {
    //var_dump($_POST);
    //retreive users
    $userDataSet = new userDataSet();

    $result = $userDataSet->loginUser($_POST["username"],$_POST["password"]);

    if($result) //if match
    {
        $user->Login($_POST["username"],$_POST["password"]);
        echo "You are logged in";
    }
    else{
        echo "Error in username and password";
    }
}

if (isset($_POST["logout-btn"]))
{
    $user->logout();
    //unset($_SESSION["login"]);
    header("Location: index.php");
    echo "logout user";
    //session_destroy();
}
