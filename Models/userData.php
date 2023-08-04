<?php

class userData implements JsonSerializable{

    protected $_id, $_username, $_email, $_photo_name, $_password, $_lat, $_lng;

    public function __construct($dbRow) {//row data returned from sql statement
        //constructing the userdata class with these values
        $this->_id = $dbRow['id'];
        $this->_username = $dbRow['username'];
        $this->_email = $dbRow['email'];
        $this->_photo_name = $dbRow['photo_name'];
        $this->_password = $dbRow['password'];
        $this->_lat = $dbRow['lat'];
        $this->_lng = $dbRow['lng'];
    }
    //return the user id of the user inside the friendship table
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
    //return the photo of the user inside the friendship table
    public function getPhotoName() {
        return $this->_photo_name;
    }
    //return the lattitude position of the user inside the friendship table
    public function getLat() {
        return $this->_lat;
    }
    //return the longtitude position of the user inside the friendship table
    public function getLng() {
        return $this->_lng;
    }

    public function jsonSerialize()
    {//returns the data json format which can be used to pares in java
        // TODO: Implement jsonSerialize() method.
        return[
            'id'=> $this->_id,
            'username'=> $this->_username,
            'email'=> $this->_email,
            'photo'=> $this->_photo_name,
            'lat'=> $this->_lat,
            'lng'=> $this->_lng,
        ];
    }
}


