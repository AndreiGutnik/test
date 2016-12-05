<?php

require_once "global_class.php";

class Menu extends GlobalClass{
    
/*переопределение родительского метода*/    
    public function __construct($db){
        parent::__construct("menu", $db);
    }
}
?>