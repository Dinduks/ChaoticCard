<?php

namespace Models;

class Card
{

    private $id;
    private $firstname;
    private $lastname;
    private $profilepicture;
    private $title;
    private $birthday;

    public function __construct($firstname = null, $lastname = null, $profilepicture = null, $title = null, \DateTime $birthday = null)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->profilepicture = $profilepicture;
        $this->title = $title;
        $this->birthday = $birthday;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getProfilepicture()
    {
        return $this->profilepicture;
    }

    public function setProfilepicture($profilepicture)
    {
        $this->profilepicture = $profilepicture;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

}
