<?php

namespace Models;

class Email
{

    private $id;
    private $email;
    private $position;

    public function __construct($email = null, $position = null)
    {
        $this->email = $email;
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
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
