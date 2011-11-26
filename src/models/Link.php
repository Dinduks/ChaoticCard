<?php

namespace Models;

class Link
{

    private $id;
    private $url;
    private $title;
    private $icon;
    private $position;

    public function __construct($url = null, $title = null, $icon = null, $position = null)
    {
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
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

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
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
