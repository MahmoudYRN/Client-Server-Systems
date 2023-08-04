<?php

class friendsData extends userData {

    protected $_friendshipID, $_friend1, $_friend2, $_status;

    public function __construct($dbRow) {
        //constructor for friends relations
        parent::__construct($dbRow);
        $this->_friendshipID = $dbRow['friendshipID'];
        $this->_friend1 = $dbRow['friend1'];
        $this->_friend2 = $dbRow['friend2'];
        $this->_status = $dbRow['status'];
    }
    //return the friendship id
    public function getFriendshipID() {
        return $this->_friendshipID;
    }
    //returns the friend request sender
    public function getFriend1() {
        return $this->_friend1;
    }
    //returns the user getting the request
    public function getFriend2() {
        return $this->_friend2;
    }
    //get the status of the friendship
    public function getStatus() {
        return $this->_status;
    }
    //return the id of the user inside the friendship table
    public function getUserID() {
        return $this->_id;
    }
    //return the username of the user inside the friendship table
    public function getUsername() {

        return $this->_username;
    }
    //return the email of the user inside the friendship table
    public function getEmail() {
        return $this->_email;
    }
    //return the name of the photo of the user inside the friendship table
    public function getPhotoName() {
        return $this->_photo_name;
    }
    //return the lattitude of the user inside the friendship table
    public function getLat() {
        return $this->_lat;
    }
    //return the longtitude of the user inside the friendship table
    public function getLng() {
        return $this->_lng;
    }

}


