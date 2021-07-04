<?php
require_once('../funcs.php');

session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
    echo 'ログインされていません。';
    echo '<a href="shop_list.php">商品一覧へ</a>';
    echo '<br />';
}

$membercode = $_SESSION['member_code'];

try {
    //Password:MAMP='root',XAMPP=''
    $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    $stmt = $dbh->prepare('SELECT 
                            name, email, postal1, postal2, address, tel 
                            FROM member WHERE membercode = '.$membercode.'');
    $stmt -> execute();
  
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    $dbh = null;
  
    $shimei  = h($result['name']);
    $email   = h($result['email']);
    $postal1 = h($result['postal1']);
    $postal2 = h($result['postal2']);
    $address = h($result['address']);
    $tel     = h($result['tel']);
    
    echo 'お名前：';
    echo $shimei;
    echo '<br />';

    echo 'メールアドレス：';
    echo $email;
    echo '<br />';

    echo '郵便番号：';
    echo $postal1;
    echo '-';
    echo $postal2;
    echo '<br />';

    echo '住所：';
    echo $address;
    echo '<br />';

    echo '電話番号：';
    echo $tel;
    echo '<br />';

  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }


    echo '<form method="post" action="shop_memberorder_done.php">';
    echo '<input type="hidden" name="shimei" value="'.$shimei.'">';
    echo '<input type="hidden" name="email" value="'.$email.'">';
    echo '<input type="hidden" name="postal1" value="'.$postal1.'">';
    echo '<input type="hidden" name="postal2" value="'.$postal2.'">';
    echo '<input type="hidden" name="address" value="'.$address.'">';
    echo '<input type="hidden" name="tel" value="'.$tel.'">';

    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '<input type="submit" value="購入する"><br />';

    echo '</form>';
?>