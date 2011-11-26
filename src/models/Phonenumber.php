<?php

namespace Models;

class Phonenumber
{

    private $id;
    private $phoneNumber;
    private $position;

    public function __construct($phoneNumber = null, $position = null)
    {
        $this->phoneNumber = $phoneNumber;
        $this->position = $position;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

}
