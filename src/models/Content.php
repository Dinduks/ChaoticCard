<?php

namespace Models;

Class Content
{

    private $id;
    private $langId;
    private $textId;

    public function __construct($langId = null, $textId = null)
    {
        $this->langId = $langId;
        $this->textId = $textId;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLangId()
    {
        return $this->langId;
    }

    public function setLangId($langId)
    {
        $this->langId = $langId;
    }

    public function getTextId()
    {
        return $this->textId;
    }

    public function setTextId($textId)
    {
        $this->textId = $textId;
    }

}
