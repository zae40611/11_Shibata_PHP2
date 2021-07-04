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

$productcode = $_POST['productcode'];
$productname = $_POST['productname'];
$price = $_POST['price'];
$pictureoldname = $_POST['pictureoldname'];
$picturenewname = $_FILES['picturenewname'];

$productcode = h($productcode);
$productname = h($productname);
$price = h($price);

if($productname == ''){
    echo '商品名が入力されていません <br />';
}else{
    echo '商品名：';
    echo $productname;
    echo '<br />';
}

if($price == ''){
    echo '価格が入力されていません <br />';
}else{
    echo '価格：';
    echo $price .'円';
    echo '<br />';
}

if($picturenewname['size']>0){
    if($picturenewname['size']>1000000){
        echo '画像が大きすぎます';
    }else{
        move_uploaded_file($picturenewname['tmp_name'],'./img/'.$picturenewname['name']);
        echo '<img src="./img/'.$picturenewname['name'].'" style="width:100px">';
        echo '<br />';
    }

}


if($productname == '' || $price == '' || $picturenewname['size']>1000000){
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}else{
    echo '上記のように変更します。<br />';
    echo '<form method="post" action="pro_edit_done.php">';
    echo '<input type="hidden" name="productcode" value="'.$productcode.'">';
    echo '<input type="hidden" name="productname" value="'.$productname.'">';
    echo '<input type="hidden" name="price" value="'.$price.'">';
    echo '<input type="hidden" name="pictureoldname" value="'.$pictureoldname.'">';
    echo '<input type="hidden" name="picturenewname" value="'.$picturenewname['name'].'">';
    echo '<br />';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '<input type="submit" value="OK">';
    echo '</form>';
}


?>