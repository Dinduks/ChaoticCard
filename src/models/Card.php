<?php

class Card
{

    private $id;
    private $firstname;
    private $lastname;
    private $profilepicture;
    private $title;
    private $secondarytitle;
    private $birthday;
    private $about;

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

    public function getSecondarytitle()
    {
        return $this->secondarytitle;
    }

    public function setSecondarytitle($secondarytitle)
    {
        $this->secondarytitle = $secondarytitle;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getAbout()
    {
        return $this->about;
    }

    public function setAbout($about)
    {
        $this->about = $about;
    }

}
