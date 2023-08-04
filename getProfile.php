<?php
//require_once('logincontroller.php');
require_once('Models/userDataSet.php');

session_start();
$q="";
$token = "";
if(isset($_SESSION["Token"])){
    $token = $_SESSION["Token"]; //read Session token and set this varible to current token
    //var_dump($_SESSION["Token"]);
}

if(!isset($_GET["token"]) || $_GET["token"] != $token){
    $view = new stdClass();
    $view->pageTitle = 'Data Unavaliable';
}
else {
    $userDataSet = new userDataSet();
//retrive data from userdata



//    $q = $_REQUEST["q"];
    $q = $_GET["q"];
    $users = $userDataSet->fetchAllUsers($q);
// get the q parameter from URL
    $hint = "";
}
// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($users as $person) {//loop through each userdata object
        $name = $person->getUsername();
        if (stristr($q, substr($name, 0, $len))) {//identify using the name
            if ($hint === "") {
                $hint = "[" . json_encode($person);//encoding the data to json data type
            } else {
                $hint .= "," . json_encode($person);
            }
        }
    }
    if ($hint != "") $hint .= "]";
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestions" : $hint;
