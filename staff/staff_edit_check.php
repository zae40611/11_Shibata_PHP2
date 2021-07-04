<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
    echo 'ログインされていません。<br />';
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}else{
    echo $_SESSION['staffname'];
    echo 'さんログイン中<br />';
    echo '<br />';
}

require_once('funcs.php');

$staffcode = $_POST['staffcode'];
$staffname = $_POST['staffname'];
$staffpass = $_POST['pass'];
$staffpass2 = $_POST['pass2'];

$staffcode = h($staffcode);
$staffname = h($staffname);
$staffpass = h($staffpass);
$staffpass2 = h($staffpass2);

if($staffname == ''){
    echo 'スタッフ名が入力されていません <br />';
}else{
    echo 'スタッフ名：';
    echo $staffname;
    echo '<br />';
}

if($staffpass == ''){
    echo 'パスワードが入力されていません <br />';
}

if($staffpass != $staffpass2){
    echo 'パスワードが一致しません。 <br />';
}

if($staffname == '' || $staffpass == '' || $staffpass != $staffpass2){
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}else{
    $staffpass=md5($staffpass);
    echo '<form method="post" action="staff_edit_done.php">';
    echo '<input type="hidden" name="staffcode" value="'.$staffcode.'">';
    echo '<input type="hidden" name="staffname" value="'.$staffname.'">';
    echo '<input type="hidden" name="pass" value="'.$staffpass.'">';
    echo '<br />';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '<input type="submit" value="OK">';
    echo '</form>';
}


?>