<?php
/*класс по работе с сообщениями - это абстрактный класс*/

require_once "config_class.php";

abstract class GlobalMessage{
    
/* в data будет храниться массив от парсинка файла
message.ini*/
    private $data;
    
    public function __construct($file){
        $config=new Config();
        $this->data=parse_ini_file($config->dir_text.$file.".ini");  
    }
    
/*получение заголовка по названию*/
    public function getTitle($name){
        return $this->data[$name."_TITLE"];
    }

/*получение текста по названию*/
    public function getText($name){
        return $this->data[$name."_TEXT"];
    }
}
?>