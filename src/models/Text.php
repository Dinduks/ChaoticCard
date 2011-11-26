<?php

namespace Models;

class Text
{

    protected $id;
    protected $text;
    protected $category;

    public function __construct($text = null, $category = null)
    {
        $this->text = $text;
        $this->category = $category;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

}