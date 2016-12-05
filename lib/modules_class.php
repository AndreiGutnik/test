<?php
/*создание абстрактного класса, который будет являться родительским для классов, отвечающих каждый за свою таблицу*/

require_once "config_class.php";
require_once "employee_class.php";
require_once "user_class.php";
require_once "menu_class.php";
require_once "message_class.php";

abstract class Modules{
    
    protected $config;
    protected $employee;
    protected $user;
    protected $menu;
    protected $message;
    protected $data;
    protected $user_info;
    
    public function __construct($db){
        session_start();
        $this->config=new Config();
        $this->employee=new Employee($db);
        $this->user=new User($db);
        $this->menu=new Menu($db);
        $this->message=new Message($db);
        $this->data=$this->secureData($_GET);
        $this->user_info=$this->getUser();
    }

/*метод. отвечающий за подстановку соответствуючих полей*/    
    public function getContent(){
        $sr["title"]=$this->getTitle();
        $sr["meta_desc"]=$this->geеDescription();
        $sr["meta_key"]=$this->getKeywords();
        $sr["menu"]=$this->getMenu();
        $sr["auth_user"]=$this->getAuthUser();
        $sr["sort"]=$this->getSort();
        $sr["top"]=$this->getTop();
        $sr["middle"]=$this->getMiddle();
        $sr["bottom"]=$this->getBottom();                                                                                                       
        return $this->getReplaceTemplate($sr, "main");
    }
    
    private function getUser(){
        $login=$_SESSION["login"];
        $password=$_SESSION["password"];
        if($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
        else return false;
    }
    
/*вспомогательные методы для метода getContent.
В этом классе, должны быть перечислены методы для подстановок. которые используются на каждой странице*/
    abstract protected function getTitle();
    abstract protected function geеDescription();
    abstract protected function getKeywords();
    abstract protected function getMiddle();
    
    protected function getMenu(){
        $menu=$this->menu->getAlls();
        for($i=0; $i<count($menu); $i++){
            $sr["title"]=$menu[$i]["title"];
            $sr["link"]=$this->config->address.$menu[$i]["link"];
            $text.=$this->getReplaceTemplate($sr, "menu_item");
        }
        return $text;
    }
    
    protected function getAuthUser(){
        if($this->user_info){
            $sr["username"]=$this->user_info["login"];
            return $this->getReplaceTemplate($sr, "user_panel");
        }
        if($_SESSION["error_auth"]==1){
            $sr["message_auth"]=$this->getMessage("ERROR_AUTH");
            unset($_SESSION["error_auth"]);
        }
        else{
            $sr["message_auth"]="";
        }
        return $this->getReplaceTemplate($sr, "form_auth");
    }
    
    protected function getTop(){
        return "";
    }
    
    protected function getSort(){
        return "";
    }

    protected function getBottom(){
        return "";
    }
    
/*проверка массива на корректность*/
    private function secureData($data){
        foreach($data as $key=>$value){
            if(is_array($value)) $this->secureData($value);
            else $data[$key]=htmlspecialchars($value);
        }
        return $data;
    }
    
/*вывод блока статей*/
    protected function getEmployees($employee, $page){
        $start=($page-1)*$this->config->count_blog;
        
        if(isset($_GET["kol"])){
            if(count($employee)<=$_GET["kol"]){
                $end=count($employee);   
            }
            else {$end=$_GET["kol"];};
        }
        else {    
            if(count($employee)>$start+$this->config->count_blog){
                $end=$start+$this->config->count_blog;
            }
            else $end=count($employee);
        }
        for($i=$start; $i<$end; $i++){
            
            $sr["surname"]=$employee[$i]["surname"];
            $sr["name"]=$employee[$i]["name"];
            $sr["fullname"]=$employee[$i]["fullname"];
            $sr["birthdate"]=$this->formatDate($employee[$i]["birthdate"]);
            $sr["dep"]=$employee[$i]["dep"];
            $sr["pos"]=$employee[$i]["pos"];
            $sr["type"]=$employee[$i]["type"];
            if($employee[$i]["type"]=="Ставка"){
                $sr["pay"]=$employee[$i]["pay"];
            }
            else $sr["pay"]=$employee[$i]["pay"]*8*21;
            $text.=$this->getReplaceTemplate($sr, "employee_intro");
        }
        $text.="</table>";
        return $text;
    }
    
    protected function formatDate($time){
        return date("d.m.Y", $time);
    }
    
    protected function getMessage($message=""){
        if($message==""){
            $message=$_SESSION["message"];
            /*для того, чтобы ошибка выводилась один раз*/
            unset($_SESSION["message"]);
        }
        $sr["message"]=$this->message->getText($message);
        return $this->getReplaceTemplate($sr, "message_string");
    }
    
    protected function getPagination($count, $count_on_page, $link){
        $count_pages=ceil($count/$count_on_page);
        $sr["number"]=1;
        $sr["link"]=$link;
        $pages=$this->getReplaceTemplate($sr, "number_page");
        if(strpos($link, "?") !== false){
            $symm="&amp;";
        }
        else $symm="?";
        for($i=2;$i<=$count_pages;$i++){
            $sr["number"]=$i;
            $sr["link"]=$link.$symm."page=$i";
            $pages.=$this->getReplaceTemplate($sr, "number_page");
        }
        $eis["number_pages"]=$pages;
        return $this->getReplaceTemplate($eis, "pagination");
    }
    
/*МЕТОДЫ ШАбЛОНИЗАТОРА*/
/*получение .tpl шаблона*/
    protected function getTemplate($name){
        $text=file_get_contents($this->config->dir_tmpl.$name.".tpl");
        return str_replace("%address%", $this->config->address, $text);
    }
    
/*замена сразу многих элементов*/
    protected function getReplaceTemplate($sr, $template){
        return $this->getReplaceContent($sr, $this->getTemplate($template));
    }
    
/*замена данных в некоторой строке*/    
    private function getReplaceContent($sr, $content){
        $search=array();
        $replace=array();
        $i=0;
        foreach($sr as $key=>$value){
            $search[$i]="%$key%";
            $replace[$i]=$value;
            $i++;
        }
        return str_replace($search, $replace, $content);
    }
    
    protected function redirect($link){
        header("Location: $link");
        exit;
    }
    
    protected function notFound(){
        $this->redirect($this->config->address."?view=notfound");
    }
}
?>