<?php
require_once "modules_class.php";

class InsertContent extends Modules{
    
    private $employees;
    
    public function __construct($db){
        parent::__construct($db);
        $this->employees=$this->employee->getAllEmp("");
    }
    
    protected function getTitle(){
        return "Добавить сотрудников";
    }
    
    protected function geеDescription(){
        return "Добавить сотрудников";
    }
    
    protected function getKeywords(){
        return "Добавить сотрудников";
    }
    
    protected function getTop(){
        return "";
    }
    
    protected function getMiddle(){
        if(!$this->user_info){
            $sr["title"]=$this->message->getTitle("ERROR_ENTRY");
            $sr["text"]=$this->message->getText("ERROR_ENTRY");
            return $this->getReplaceTemplate($sr, "message");
        }
        else { 
            return $this->getTemplate("insert");
        }
    }
    
    protected function getBottom(){
        return "";
    }
}
?>