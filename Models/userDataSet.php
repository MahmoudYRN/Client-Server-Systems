<?php
require_once ('Models/Database.php');
require_once ('Models/userData.php');
require_once ('Models/friendsData.php');

class userDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();//make call to database connection
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }
    //return all friends from user friendlist
    public function fetchAllFriends($currentuser) {
        $sqlQuery = "SELECT * FROM (
    SELECT * FROM users 
    WHERE users.id in (
        SELECT friend1 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT id FROM users WHERE username = '$currentuser') AND friends.status=2 or friends.friend2 = (SELECT id FROM users WHERE username = '$currentuser') AND friends.status=2)
        union 
        SELECT friend2 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT  id FROM users WHERE username = '$currentuser') AND friends.status=2 or friends.friend2 = (SELECT  id FROM users WHERE username = '$currentuser') AND friends.status=2)
        ) and users.id != (SELECT id FROM users WHERE username = '$currentuser')) ping inner join friends WHERE ((friend1=ping.id and friend2=(SELECT  id FROM users WHERE username = '$currentuser'))or(friend1=(SELECT  id FROM users WHERE username = '$currentuser') AND friend2=ping.id))";
        //statement for searching all friends from database
        // but exclude logged in user from the list
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new friendsData($row);//creates new userdata with this raw data
        }
        return $dataSet;
    }
    //return only specified friends
    public function fetchSomeFriends($userID, $friend) {
        $sqlQuery = "SELECT * FROM (
    SELECT * FROM users
    WHERE username LIKE '$friend'  AND users.id in (
        SELECT friend1 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT id FROM users WHERE username = '$userID') AND friends.status=2 or friends.friend2 = (SELECT id FROM users WHERE username = '$userID') AND friends.status=2)
        union 
        SELECT friend2 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT  id FROM users WHERE username = '$userID') AND friends.status=2 or friends.friend2 = (SELECT  id FROM users WHERE username = '$userID') AND friends.status=2)
        ) and users.id != (SELECT id FROM users WHERE username = '$userID')) ping inner join friends WHERE ((friend1=ping.id and friend2=(SELECT  id FROM users WHERE username = '$userID'))or(friend1=(SELECT  id FROM users WHERE username = '$userID') and friend2=ping.id))";
        //statement for searching all friends from database
        // but exclude logged in user from the list
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new friendsData($row);
        }//return object if friends
        return $dataSet;
    }
    //return all the incoming and outgoing friend requests
    public function fetchAllFriendRequests($userID) {
        $sqlQuery = "SELECT * FROM (
    SELECT * FROM users
    WHERE users.id in (
        SELECT friend1 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT id FROM users WHERE username = '$userID') AND friends.status!=2 or friends.friend2 = (SELECT id FROM users WHERE username = '$userID') AND friends.status!=2)
        union 
        SELECT friend2 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT  id FROM users WHERE username = '$userID') AND friends.status!=2 or friends.friend2 = (SELECT  id FROM users WHERE username = '$userID') AND friends.status!=2)
        ) and users.id != (SELECT id FROM users WHERE username = '$userID')) ping inner join friends WHERE ((friend1=ping.id and friend2=(SELECT  id FROM users WHERE username = '$userID'))or(friend1=(SELECT  id FROM users WHERE username = '$userID') and friend2=ping.id))";
        //statement for searching all users from database
        // but exclude logged in user from the list
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new friendsData($row);
        }
        return $dataSet;
    }
    //return specified friend from the friend list
    public function fetchSomeFriendRequests($userID,$search) {
        $sqlQuery = "SELECT * FROM (
    SELECT * FROM users
    WHERE username = '$search' and users.id in (
        SELECT friend1 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT id FROM users WHERE username = '$userID') AND friends.status!=2 or friends.friend2 = (SELECT id FROM users WHERE username = '$userID') AND friends.status!=2)
        union 
        SELECT friend2 as friend
        FROM friends
        WHERE (friends.friend1 = (SELECT  id FROM users WHERE username = '$userID') AND friends.status!=2 or friends.friend2 = (SELECT  id FROM users WHERE username = '$userID') AND friends.status!=2)
        ) and users.id != (SELECT id FROM users WHERE username = '$userID')) ping inner join friends WHERE ((friend1=ping.id and friend2=(SELECT  id FROM users WHERE username = '$userID'))or(friend1=(SELECT  id FROM users WHERE username = '$userID') and friend2=ping.id))";
        //statement for searching all friends from database
        // but exclude logged in user from the list
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new friendsData($row);
        }
        return $dataSet;
    }
    //send a friend request to chosen user
    public function makeFriendRequest($myID,$friendshipID)
    {
        $sqlQuery = "INSERT INTO friends (friend1, friend2, status)
        VALUES ((SELECT DISTINCT id FROM users WHERE username = '$myID'), '$friendshipID', 1)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new friendsData($row);
        }
        return $dataSet;
    }
    //accept the friend request where specified
    public function acceptRequest($friendshipID) {
        $sqlQuery = "UPDATE friends SET status = 2 WHERE friendshipID = '".$friendshipID."'";
        $statement = $this->_dbHandle->prepare($sqlQuery);//statement for executing this command
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new friendsData($row);
        }
        return $dataSet;
    }
    //deny the requst and delete it from request lists
    public function denyRequest($friendshipID) {
        $sqlQuery = "DELETE FROM friends WHERE friendshipID = '".$friendshipID."'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new friendsData($row);
        }
        return $dataSet;
    }
    //completely removes friend from the friendlist
    public function removeFriend($friendshipID) {
        $sqlQuery = "DELETE FROM friends WHERE friendshipID = '".$friendshipID."'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }
    //return all of the users from user table
    public function fetchAllUsers($userID) {
        $sqlQuery = "SELECT * FROM users WHERE username NOT LIKE'".$userID."'";
        $statement = $this->_dbHandle->prepare($sqlQuery);//exclude current user from the list
        $statement->execute();
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new userData($row);
        }
        return $dataSet;
    }

    public function fetchSomeUsers($searchText) {
        $sqlQuery = "SELECT * FROM users WHERE username LIKE'".$searchText."'";
        //search for users with the given paramenter
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new userData($row);
        }
        return $dataSet;
    }
    //only return a single user by their unique id
    public function fetchUserByID($id) {
        $sqlQuery = "SELECT * FROM users WHERE id ='".$id."'";
        //search users by their id instead of name
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new userData($row);
        }
        return $dataSet;
    }
    //authenticate the login
    public function loginUser($username, $password) {
        $sqlQuery = 'SELECT * FROM users WHERE username=? AND password=?';
        //check if the username and password is a match
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindParam(1, $username);
        $statement->bindParam(2, $password);

        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new userData($row);
        }
        return $dataSet;
    }
    //create a new user in user table
    public function registerUser($username, $email, $photo_name, $password, $lat,$lng) {
        $sqlQuery = 'INSERT INTO users (username,email,photo_name,password,lat,lng)VALUES(?,?,?,?,?,?)';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        //create new user with the given values
        $statement->bindParam(1, $username);
        $statement->bindParam(2, $email);
        $statement->bindParam(3, $photo_name);
        $statement->bindParam(4, $password);
        $statement->bindParam(5, $lat);
        $statement->bindParam(6, $lng);

        return $statement->execute(); // execute the PDO statement
    }

    //update the location lattitude and longtitude of the user
    public function updateLocation($userID,$lat, $lng){
        $sqlQuery = "UPDATE users SET lat = '$lat', lng = '$lng' WHERE username = '$userID'";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        return $statement->execute();
    }



}