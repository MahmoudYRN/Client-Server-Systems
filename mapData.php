<?php
require_once('logincontroller.php');
require_once('Models/userDataSet.php');
$userDataSet = new userDataSet();

//retrive data from userdata
$users = $userDataSet->fetchAllFriends($user->usernameLogged());

$mapDta = ""; //empty string variable
foreach($users as $person) {//loop through each of the userdata objects
    if ($mapDta === "") {//if we have an empty string encode each of the object
        $mapDta = "[" . json_encode($person);
    } else {//otherwise do this
        $mapDta .= "," . json_encode($person);
    }
}
//wrapping the data in the correct format before returning to xml request
if ($mapDta != "") $mapDta .= "]";
echo $mapDta;
?>