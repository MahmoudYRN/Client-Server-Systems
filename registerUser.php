<?php
require_once("logincontroller.php");
require_once('Models/userData.php');
require_once('Models/userDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Register user';

$userData = new userDataSet();
$user = new user();

$view->dbMessage ="";
$view->loginError = false;

if(isset($_POST["registerbutton"])){
    //var_dump($_POST);
    $userDataSet = new userDataSet();
    //register user
    $result = $userDataSet->registerUser($_POST["username"],$_POST["email"],$_POST["img"],$_POST["password"],"2.3234","34.2343");
    //calling sql function and insert this information to it
    echo "You are logged in";
    $user->Login($_POST["username"],$_POST["password"]);
   // $_SESSION["login"] = ($_POST["username"]);

    header("Location: index.php");
    exit();
    //redirects user to main page after sign up
}

require_once('Views/registerUser.phtml');