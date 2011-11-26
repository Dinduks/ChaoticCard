<?php

class ChaoticCardUtil 
{

    public static function getClientLanguage($defaultLang = 'en') 
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            return substr($langs[0], 0, 2);
        } else {
            return $defaultLang;
        }
    }

}
