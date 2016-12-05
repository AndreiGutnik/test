<?php

require_once "global_class.php";

class User extends GlobalClass{
    
/*переопределение родительского метода*/    
    public function __construct($db){
        parent::__construct("users", $db);
    }
    
/*добавление нового пользователя*/
    public function addUser($login, $password, $regdate){
        if(!$this->CheckValid($login, $password, $regdate)) return false;
        return $this->add(array("login"=>$login, "password"=>$password, "regdate"=>$regdate));
    }
    
/*редактирование пользователя*/
    public function editUser($id, $login, $password, $regdate){
        if(!$this->CheckValid($login, $password, $regdate)) return false;
        return $this->edit($id, array("login"=>$login, "password"=>$password, "regdate"=>$regdate));
    }
    
/*проверка существования данного логина*/
    public function isExistsUser($login){
        return $this->isExist("login", $login);
    }
    
    public function checkUser($login, $password){
        $user=$this->getUserOnLogin($login);
        if(!$user) return false;
        return $user["password"]===$password;
        
    }
    
/*получение всех данных пользователя по логину*/
    public function getUserOnLogin($login){
        $id=$this->getField("id", "login", $login);
        return $this->get($id);
    }
       
/*проверка введенных данных*/
    private function CheckValid($login, $password, $regdate){
        if(!$this->valid->validLogin($login)) return false;
        if(!$this->valid->validHash($password)) return false;
        if(!$this->valid->validTimetamp($regdate)) return false;
        return true;
    }
}
?>