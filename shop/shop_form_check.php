<?php

session_start();
session_regenerate_id(true);


require_once('../funcs.php');

$shimei  = h($_POST['shimei']);
$email   = h($_POST['email']);
$postal1 = h($_POST['postal1']);
$postal2 = h($_POST['postal2']);
$address = h($_POST['address']);
$tel     = h($_POST['tel']);
$order   = h($_POST['order']);
$pass    = h($_POST['pass']);
$pass2   = h($_POST['pass2']);
$sex     = h($_POST['sex']);
$birth   = h($_POST['birth']);


echo '【お客様情報確認】<br />';

$okflg = true;

if($shimei == ''){
    echo 'お名前が入力されていません<br /><br />';
    $okflg = false;
}else{
    echo 'お名前：';
    echo $shimei;
    echo '<br />';
}

$reg_email = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
if(preg_match($reg_email,$email) == 0){
    echo 'メールアドレスを正確に入力してください。<br /><br />';
    $okflg = false;
}else{
    echo 'メールアドレス：';
    echo $email;
    echo '<br />';
}

if(preg_match("/^[0-9]+$/",$postal1)==0){
    echo '郵便番号は半角数字で入力してください。<br /><br />';
    $okflg = false;
}else{
    echo '郵便番号：';
    echo $postal1;
    echo '-';
    echo $postal2;
    echo '<br />';
}

if(preg_match("/^[0-9]+$/",$postal2)==0){
    echo '郵便番号は半角数字で入力してください。<br /><br />';
    $okflg = false;
}

if($address==''){
    echo '住所が入力されていません。<br /><br />';
    $okflg = false;
}else{
    echo '住所：';
    echo $address;
    echo '<br />';
}

$reg_tel ="/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/";
if(preg_match($reg_tel,$tel)==0){
    echo '電話番号をハイフン付きで正確に入力してください。<br /><br />';
    $okflg = false;
}else{
    echo '電話番号：';
    echo $tel;
    echo '<br />';
}

///////////会員登録希望者の確認事項//////////////// 
if($order=='memberreg'){
    if($pass==''){
        echo 'パスワードが入力されていません<br /><br />';
        $okflg=false;
    }

    if($pass != $pass2){
        echo 'パスワードが一致しません。<br /><br />';
        $okflg=false;
    }

    echo '性別<br />';
    if($sex == 'male'){
        echo '男性';
    }else{
        echo '女性';
    }
    echo '<br /><br />';

    echo '生まれた年代<br />';
    echo $birth.'年代';
    echo '<br /><br />';
}

//DB接続
try {

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);

    $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
    $honbun = '';
    for($i=0; $i<$max; $i++){
        $stmt = $dbh->prepare('SELECT productname, price FROM product WHERE productcode = '.$cart[$i].'');
        // $data[0] =$cart[$i];
        $stmt -> execute();
  
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $name = $result['productname'];
        $price = $result['price'];
        $amount = $kazu[$i];
        $shoukei = $price * $amount;
        $total += $price*$amount;
        $n = $i + 1;

        $honbun .= $n.'.'.$name.' : <br />';
        $honbun .= $price.'円 x';
        $honbun .= $amount.'個 =';
        $honbun .= $shoukei.'円 <br /><br />';
        
      }
        $honbun .= '合計：';
        $honbun .= $total.'円 <br /><br />';
  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }
  

if($okflg == true){
    
    echo '<br /><br />【ご購入商品確認】<br /><br />';
    echo $honbun;


    echo '<form method="post" action="shop_form_done.php">';
    echo '<input type="hidden" name="shimei" value="'.$shimei.'">';
    echo '<input type="hidden" name="email" value="'.$email.'">';
    echo '<input type="hidden" name="postal1" value="'.$postal1.'">';
    echo '<input type="hidden" name="postal2" value="'.$postal2.'">';
    echo '<input type="hidden" name="address" value="'.$address.'">';
    echo '<input type="hidden" name="tel" value="'.$tel.'">';
    echo '<input type="hidden" name="order" value="'.$order.'">';
    echo '<input type="hidden" name="pass" value="'.$pass.'">';
    echo '<input type="hidden" name="sex" value="'.$sex.'">';
    echo '<input type="hidden" name="birth" value="'.$birth.'">';

    echo 'よろしければ【購入する】するボタンをクリックしてください。<br /><br />';

    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '<input type="submit" value="購入する"><br />';
    echo '</form>';



}else{
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}





?>