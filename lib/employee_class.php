<?php

require_once "global_class.php";

class Employee extends GlobalClass{
    
/*переопределение родительского метода*/    
    public function __construct($db){
        parent::__construct("employees", $db);
    }
    
    public function getAllEmp($sort){
        return $this->getAlls($sort, true);
    }
    
    public function delAllEmp(){
        return $this->delAll();
    }
    
    public function addEmp(){
        $doc = new DomDocument();
        $doc->load("XML/list.xml");
        $data = $doc->saveXML();
        $list = new SimpleXMLElement($data);
        for($i=0; $i<count($list); $i++){
            $val=array('surname'=>$list->Employee[$i]->surname, 'name'=>$list->Employee[$i]->name, 'fullname'=>$list->Employee[$i]->fullname, 'birthdate'=>strtotime($list->Employee[$i]->birthdate), 'dep'=>$list->Employee[$i]->dep, 'pos'=>$list->Employee[$i]->pos, 'type'=>$list->Employee[$i]->type, 'pay'=>$list->Employee[$i]->pay);
            $r=$this->add($val);
        } 
        return $r;  
    }
}
?>