<?php
/*абстрактный родительский класс, который содержит методы,
присущие всем дочерним классам работы с данными для
каждой таблицы*/

require_once "config_class.php";
require_once "checkvalid_class.php";
require_once "database_class.php";

abstract class GlobalClass{
    
    private $db;
    private $table_name;
    protected $config;
    protected $valid;
    
    protected function __construct($table_name, $db){
        $this->db=$db;
        $this->table_name=$table_name;
        $this->config=new Config();
        $this->valid=new CheckValid();
    }

/*добавление новой записи*/
    protected function add($new_values){
        return $this->db->insert($this->table_name, $new_values);
    }
    
/*обновление записи по id*/
    protected function edit($id, $upd_fields){
        return $this->db->updateOnID($this->table_name, $id, $upd_fields);
    }
    
/*удалени записи по id*/
    public function delete($id){
        return $this->db->deleteOnID($this->table_name, $id);
    }
    
/*удвление всего*/
    public function delAll(){
        return $this->db->alldelete($this->table_name);
    }
    
/*получение поля по известному значению другого поля*/
    protected function getField($field_out, $field_in, $value_in){
        return $this->db->getField($this->table_name, $field_out, $field_in, $value_in);
    }
    
/*получение значения поля по id*/
    protected function getFieldOnID($id, $field){
        return $this->db->getFieldOnID_db($this->table_name, $id, $field);
    }
    
/*изменение значения поля по id*/
    protected function setFieldOnID($id, $field, $value){
        return $this->db->setFieldOnIDdb($this->table_name, $id, $field, $value);
    }
    
/*получение всей записи целиком по id*/
    public function get($id){
        return $this->db->getElementOnID($this->table_name, $id);
    }
    
/*получение всех записей*/
    public function getAlls($order="", $up=true){
        return $this->db->getAll_db($this->table_name, $order, $up);
    }
    
/*получение всех записей по определенному полю*/
    protected function getAllOnFields($field, $value, $order="", $up=true){
        return $this->db->getAllOnField($this->table_name, $field, $value, $order, $up);
    }

/*получение случайных записей в определенном количестве*/
    public function getRandomElements($count){
        return $this->db->getRandomElements($this->table_name, $count);
    }
    
/*получение id последней вставленной записи*/
    public function getLastID(){
        return $this->db->getLastID($this->table_name);
    }
    
/*вывод количества записей в таблице*/
    public function getCount(){
        return $this->db->getCount($this->table_name);
    }
    
/*проверка наличия записи в таблице по известному значению поля*/    
    public function isExist($field, $value){
        return $this->db->isExists($this->table_name, $field, $value);
    }
}
?>