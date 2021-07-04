<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
    echo 'ログインされていません。<br />';
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}

if(isset($_POST['disp']) == true){
    if(isset($_POST['productcode'])==false){
        header('Location:pro_ng.php');
        exit();
    }
    $productcode=$_POST['productcode'];
    header('Location:pro_disp.php?productcode='.$productcode); 
    exit();
}

if(isset($_POST['add']) == true){
    header('Location:pro_add.php'); 
    exit();
}

if(isset($_POST['edit']) == true){
    if(isset($_POST['productcode'])==false){
        header('Location:pro_ng.php');
        exit();
    }
    $productcode=$_POST['productcode'];
    header('Location:pro_edit.php?productcode='.$productcode); 
    exit();
}

if(isset($_POST['delete']) == true){
    if(isset($_POST['productcode'])==false){
        header('Location:pro_ng.php');
        exit();
    }
    $productcode=$_POST['productcode'];
    header('Location:pro_delete.php?productcode='.$productcode); 
    exit();
}


?>