<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
    echo 'ログインされていません。<br />';
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}

if(isset($_POST['disp']) == true){
    if(isset($_POST['staffcode'])==false){
        header('Location:staff_ng.php');
        exit();
    }
    $staffcode=$_POST['staffcode'];
    header('Location:staff_disp.php?staffcode='.$staffcode); 
    exit();
}

if(isset($_POST['add']) == true){
    header('Location:staff_add.php'); 
    exit();
}

if(isset($_POST['edit']) == true){
    if(isset($_POST['staffcode'])==false){
        header('Location:staff_ng.php');
        exit();
    }
    $staffcode=$_POST['staffcode'];
    header('Location:staff_edit.php?staffcode='.$staffcode); 
    exit();
}

if(isset($_POST['delete']) == true){
    if(isset($_POST['staffcode'])==false){
        header('Location:staff_ng.php');
        exit();
    }
    $staffcode=$_POST['staffcode'];
    header('Location:staff_delete.php?staffcode='.$staffcode); 
    exit();
}


?>