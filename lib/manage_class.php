<?php
require_once "config_class.php";
require_once "user_class.php";
require_once "lib/employee_class.php";

class Manage {
    
    private $config;
    private $user;
    private $employee;
    private $data;
    
    public function __construct($db){
        session_start();
        $this->config=new Config();
        $this->employee=new Employee($db);
        $this->user=new User($db);
        $this->data=$this->secureData(array_merge($_POST, $_GET));
    }
    
    /*проверка массива на корректность*/
    private function secureData($data){
        foreach($data as $key=>$value){
            if(is_array($value)) $this->secureData($value);
            else $data[$key]=htmlspecialchars($value);
        }
        return $data;
    }

/*функция, отвечающая за релирект после завершения какого-либо действия*/    
    public function redirect($link){
        header("Location: $link");
        exit;
    }
    
/*регистрация пользователя*/
    public function regUser(){
        $link_reg=$this->config->address."?view=reg";
        $captcha=$this->data["сaptcha"];
        if(($_SESSION["rand"]!=$captcha) && ($_SESSION["rand"]!="")){
            return $this->returnMessage("ERROR_CAPTCHA", $link_reg);
        }
        $login=$this->data["login"];
        if($this->user->isExistsUser($login)) return $this->returnMessage("EXISTS_LOGIN", $link_reg);
        $password=$this->data["password"];        
        if($password=="") return $this->unknownError($link_reg);
        $password=$this->hashPassword($password);
        $result=$this->user->addUser($login, $password, time());
        if($result) return $this->returnPageMessage("SUCCESS_REG", $this->config->address."?view=message");
        else return $this->unknownError($link_reg);
    }
    
    public function login(){
        $login=$this->data["login"];
        $password=$this->data["password"];
        $password=$this->hashPassword($password);
        $r=$_SERVER["HTTP_REFERER"];
        if($this->user->checkUser($login, $password)){
            $_SESSION["login"]=$login;
            $_SESSION["password"]=$password;
            return $r;
        }
        else{
            $_SESSION["error_auth"]=1;
            return $r;
        }
    }
    
    public function logout(){
        unset($_SESSION["login"]);
        unset($_SESSION["password"]);
        return $_SERVER["HTTP_REFERER"];
    }
    
    private function hashPassword($password){
        return md5($password.$this->config->secret);
    }
    
    public function unknownError($r){
        return $this->returnMessage("UNKNOWN_ERROR" ,$r);
    }
    
    public function delAllEmployee(){
        $link_del=$this->config->address."?view=delete";
        $result=$this->employee->delAllEmp();
        if($result) return $this->returnPageMessage("SUCCESS_DEL", $this->config->address."?view=message");
        else return $this->unknownError($link_del);
        
    }
    
    public function uplEmp(){
        $link_upl=$this->config->address."?view=insert";
        $result=$this->employee->addEmp();
        if($result) return $this->returnPageMessage("SUCCESS_ADD", $this->config->address."?view=message");
        else return $this->unknownError($link_upl);     
    }
    
    private function returnMessage($message, $r){
        $_SESSION["message"]=$message;
        return $r;
    }
    
    private function returnPageMessage($message, $r){
        $_SESSION["page_message"]=$message;
        return $r;
    }
}
?>