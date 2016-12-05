<?php
require_once "modules_class.php";

class RegContent extends Modules{
    
    public function __construct($db){
        parent::__construct($db);
    }
    
    protected function getTitle(){
        return "Регистрация на сайте";
    }
    
    protected function geеDescription(){
        return "Регистрация пользователя на сайте";
    }
    
    protected function getKeywords(){
        return "регистация, пользователь, сайт";
    }
    
    protected function getMiddle(){
        $sr["message"]=$this->getMessage();
        $sr["login"]=$_SESSION["login"];
        return $this->getReplaceTemplate($sr, "form_reg");
    }
}
?>