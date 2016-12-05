<?php
    mb_internal_encoding("UTF-8");
    
    require_once "lib/database_class.php";
    require_once "lib/frontpagecontent_class.php";
    require_once "lib/regcontent_class.php";
    require_once "lib/messagecontent_class.php";
    require_once "lib/notfoundcontent_class.php";
    require_once "lib/insertcontent_class.php";
    require_once "lib/deletecontent_class.php";
    
    $db=new Database();
    if(isset($_GET["view"])) $view=$_GET["view"];
    else $view="";
    switch ($view){
        case "":
            $content=new FrontpageContent($db);
        break;
        case "insert":
            $content=new InsertContent($db);
        break;
        case "delete":
            $content=new DeleteContent($db);
        break;
        case "reg":
            $content=new RegContent($db);
        break;
        case "message":
            $content=new MessageContent($db);
        break;
        case "notfound":
            $content=new NotFoundContent($db);
        break;
        default: $content = new NotFoundContent($db);
    }    
    echo $content->getContent();
?>