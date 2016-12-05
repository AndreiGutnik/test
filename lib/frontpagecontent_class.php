<?php
require_once "modules_class.php";

class FrontpageContent extends Modules{
    
    private $employees;
    private $page;
    
    public function __construct($db){
        parent::__construct($db);
        $this->employees=$this->employee->getAllEmp("");
        
        if(isset($this->data["page"])){
            $this->page=$this->data["page"];
        }
        else{
            $this->page=1;
        }
    }
    
    protected function getTitle(){
        if($this->page>1) return "Список сотрудников -- Страница ".$this->page;
        return "Список сотрудников";
    }
    
    protected function geеDescription(){
        return "Список сотрудников";
    }
    
    protected function getKeywords(){
        return "Список сотрудников";
    }
    
    protected function getTop(){
        if(!$this->user_info){
            $sr["title"]=$this->message->getTitle("ERROR_ENTRY");
            $sr["text"]=$this->message->getText("ERROR_ENTRY");
            return $this->getReplaceTemplate($sr, "message");
        }
        else { 
            return $this->getTemplate("main_list");
        }
    }
    
    protected function getMiddle(){
        if($this->user_info){  
            if(isset($_GET["sort"])){
                $sort=$_GET["sort"];
                $this->employees=$this->employee->getAllEmp($sort);
                return $this->getEmployees($this->employees, $this->page);
            }
            elseif(isset($_GET["sort"])) {
                
            }
            else {
                return $this->getEmployees($this->employees, $this->page);
            }
        }
    }
    
    protected function getSort(){
        if($this->user_info){
            $sr[""] = "";
            return $this->getReplaceTemplate($sr, "sort");
        }   
    }
    
    protected function getBottom(){
        if($this->user_info){
            return $this->getPagination(count($this->employees), $this->config->count_blog, $this->config->address);
        }
    }    
}
?>