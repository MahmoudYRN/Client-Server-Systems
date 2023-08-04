<?php
require_once('logincontroller.php');
require_once('Models/userDataSet.php');
require_once('Models/userData.php');

$view = new stdClass();
$view->pageTitle = 'Friend Requests';

$userDataSet = new userDataSet();
$userID = $user->usernameLogged();
$userPhotos = $userDataSet->fetchSomeUsers($userID);
//retreives photo for logged in user

if (isset($_POST["searchButton"])) {
    $userDataSet = $userDataSet->fetchSomeFriendRequests($userID,$_POST["search-text"]);
}
else // show all friends request if no search given
{
    $userDataSet = $userDataSet->fetchAllFriendRequests($userID);
}

$friends = new userDataSet();

//check which button is pressed and call function accordingly
if(isset($_POST["Accept"])){
    $id = $_GET['id'];
    $friends->acceptRequest($id);
}
elseif(isset($_POST["Deny"])){
    $id = $_GET['id'];
    $friends->denyRequest($id);
}
elseif(isset($_POST["Remove"])){
    $id = $_GET['id'];
    $friends->removeFriend($id);
}
elseif(isset($_POST["Cancel"])){
    $id = $_GET['id'];
    $friends->denyRequest($id);
}
elseif(isset($_POST["addFriend"])){
    $id = $_GET['id'];
    $myID = $userID;
    $friends->makeFriendRequest($myID,$id);
}


require_once('Views/requests.phtml');
