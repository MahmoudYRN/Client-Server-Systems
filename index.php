<?php
require_once('logincontroller.php');
require_once('Models/userDataSet.php');
require_once('Models/userData.php');

$view = new stdClass();
$view->pageTitle = 'Homepage';


$userDataSet = new userDataSet();
$friends = $userDataSet;
$userID = "";
if($user->isLoggedIn()){
//    $userID = $_SESSION["login"];

    $userID = $user->usernameLogged();
}
$userPhotos = $userDataSet->fetchSomeUsers($userID);


if (isset($_POST["searchButton"])) {
    $userDataSet = $userDataSet->fetchSomeUsers($_POST["search-text"]);
    // only show user if the button is pressed and input has a value
}
//if suggested name is clicked
elseif(isset($_GET['id'])){
    $id = $_GET['id'];
    //fetch one user using the id
    $userDataSet = $userDataSet->fetchUserByID($id);
}
else
{
// show the default of all records
    $userDataSet = $userDataSet->fetchAllUsers($userID);
}


require_once('Views/index.phtml');
