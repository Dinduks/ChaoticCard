<?php

namespace Models;

Class Content
{

    private $id;
    private $lang_id;
    private $text_id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLang_id()
    {
        return $this->lang_id;
    }

    public function setLang_id($lang_id)
    {
        $this->lang_id = $lang_id;
    }

    public function getText_id()
    {
        return $this->text_id;
    }

    public function setText_id($text_id)
    {
        $this->text_id = $text_id;
    }

}
