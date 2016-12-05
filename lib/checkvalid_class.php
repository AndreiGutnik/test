<?php
/*
1. validID($id) Проверка идентификатора на корректность (является целым, не "0" и не отрицательное).
2. validLogin($login) Проверка логина на корректность (не содержит спецсимволов, соответствует регулярному выражению, находится в пределах минимального и максимального количества символов).
3. validHash($hash) Проверка пароля (хеша) на корректность.
4. validTimetamp($time) Проверка даты регистрации на корректность(является ли число >=0).
*/
require_once "config_class.php";

class CheckValid{
    private $config;
    
    public function __construct(){
        $this->config = new Config();
    }

/*проверка идентификатора на корректность (является целым, не "0" и не отрицательное)*/    
    public function validID($id){
        if(!$this->IsIntNumber($id))return false;
        if($id<=0) return false;
        else return true;
    }

/*проверка логина на корректность (не содержит спецсимволов, соответствует регулярному выражению, находится в пределах минимального и максимального количества символов)*/    
    public function validLogin($login){
        if($this->isContainQuotes($login)) return false;
        if(preg_match("/^\d*$/", $login)) return false;
        return $this->validString($login, $this->config->min_login, $this->config->max_login);
    }
    
/*проверка корректности количества проголосовавших в голосования*/
    public function validVotes($votes){
    	return $this->isNoNegativeInteger($votes);
    }
    
/*проверка пароля на корректность*/    
    public function validHash($hash){
        if(!$this->validString($hash, 32, 32)) return false;
        if(!$this->isOnlyLettersAndDigits($hash)) return false;
        return true;
    }
    
/*проверка даты регистрации на корректность*/    
    public function validTimetamp($time){
        return $this->isNoNegativeInteger($time);
    }
    
/*проверка, является ли число целым*/
    private function isIntNumber($number){
        if(!is_int($number) && !is_string($number)) return false;
        if(!preg_match("/^-?(([1-9][0-9]*|0))$/", $number)) return false;
        return true;
    }
    
/*проверка является ли число >=0*/
    private function isNoNegativeInteger($number){
        if(!$this->isIntNumber($number)) return false;
        if($number < 0) return false;
        return true;
    }
    
/*наличие в строке только букв и цифр*/
    private function isOnlyLettersAndDigits($string){
        $reg="/[a-zа-я0-9]*/i";
        if(!is_int($string) && (!is_string($string))) return false;
        if(!preg_match($reg, $string)) return false;
        return true;
    }
    
/*проверка строки*/
    private function validString($string, $min_string, $max_string){
        if(!is_string($string)) return false;
        if(strlen($string)<$min_string) return false;
        if(strlen($string)>$max_string) return false;
        return true;
    }
    
/*проверка на наличие кавычек в строке*/
    private function isContainQuotes($string){
        $array=array("\"", "'", "`", "&quot;", "&apos;");
        foreach($array as $key=>$value){
            if(strpos($string, $value)!=false) return true;
        }
        return false;
    }
} 
?>