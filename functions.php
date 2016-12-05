<?php
require_once "lib/database_class.php";
require_once "lib/manage_class.php";

$db=new Database();
$manage=new Manage($db);
if(isset($_POST["reg"])){
    $r=$manage->regUser();
}
elseif(isset($_POST["auth"])) {
    $r=$manage->login();
}
elseif(isset($_GET["logout"])){
    $r=$manage->logout();
}
elseif(isset($_POST["del"])){
    $r=$manage->delAllEmployee();
}
elseif(isset($_POST["upload"])){
    $uploaddir = 'XML/';
    $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
    if($_FILES['uploadfile']['type']=="text/xml"){
        copy($_FILES['uploadfile']['tmp_name'], $uploadfile);
    }
    $r=$manage->uplEmp();
}
    
else exit;
$manage->redirect($r);
?>