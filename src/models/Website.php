<?php

namespace Models;

class Website
{

    protected $id;
    protected $url;
    protected $title;
    protected $position;
    
    public function __construct($url = null, $title = null, $position = null)
    {
        $this->url = $url;
        $this->title = $title;
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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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
