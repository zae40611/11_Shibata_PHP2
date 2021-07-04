<?php

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


if($okflg == true){
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
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '<input type="submit" value="OK"><br />';
    echo '</form>';
}else{
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}





?>