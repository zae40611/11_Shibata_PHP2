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

$productname = $_POST['productname'];
$price = $_POST['price'];
$picture = $_FILES['picture'];

$productname = h($productname);
$price = h($price);

if($productname == ''){
    echo '商品名が入力されていません <br />';
}else{
    echo '商品名：';
    echo $productname;
    echo '<br />';
}

if(preg_match('/^[0-9]+$/',$price) == 0){
    echo '価格を半角数字で入力してください。 <br />';
}else{
    echo '価格：';
    echo $price;
    echo '円<br />';
}

if($picture['size']>0){
    if($picture['size']>1000000){
        echo '画像が大きすぎます';
    }else{
        move_uploaded_file($picture['tmp_name'],'./img/'.$picture['name']);
        echo '<img src="./img/'.$picture['name'].'" style="width:100px">';
        echo '<br />';
    }

}


if($productname == '' || preg_match('/^[0-9]+$/',$price) == 0 || $picture['size']>1000000){
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}else{
    echo '上記の商品を追加します。<br />';
    echo '<form method="post" action="pro_add_done.php">';
    echo '<input type="hidden" name="productname" value="'.$productname.'">';
    echo '<input type="hidden" name="price" value="'.$price.'">';
    echo '<input type="hidden" name="picturename" value="'.$picture['name'].'">';
    echo '<br />';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '<input type="submit" value="OK">';
    echo '</form>';
}


?>