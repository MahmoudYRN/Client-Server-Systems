<?php
require_once('logincontroller.php');
require_once('Models/userDataSet.php');

$userDataSet = new userDataSet();
//$lat = $_REQUEST["q"];
$location = $_REQUEST["q"];

$coords = explode(",", $location);
$lat = $coords[0]; // lattitude
$lng = $coords[1]; // longtitude
$userID = $user->usernameLogged();

$userDataSet->updateLocation($userID,$lat,$lng);
