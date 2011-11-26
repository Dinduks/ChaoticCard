<?php

namespace Models;

class Lang
{

    protected $id;
    protected $lang;

    public function __construct($lang = null)
    {
        $this->lang = $lang;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

}
