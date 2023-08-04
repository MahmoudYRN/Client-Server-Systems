<?php
require_once('logincontroller.php');
require_once('Models/userDataSet.php');
require_once('Models/userData.php');

$view = new stdClass();
$view->pageTitle = 'Friends System';
$userDataSet = new userDataSet();

$userID = $user->usernameLogged();
$userPhotos = $userDataSet->fetchSomeUsers($userID);


if (isset($_POST["searchButton"])) {
    // if search button pressed call this function with the text value
    $userDataSet = $userDataSet->fetchSomeFriends($userID,$_POST["search-text"]);
}
else
{
    //call function to return all friends
    $userDataSet = $userDataSet->fetchAllFriends($userID);
}






require_once('Views/friends.phtml');
