<?php

require_once('../funcs.php');

// 1. POSTデータ取得
$member_email = $_POST['email'];
$member_pass = $_POST['pass'];

$member_email = h($member_email);
$member_pass = h($member_pass);

// $member_pass=md5($member_pass);

// 2. DB接続します
try {               //try-catch文  ロジック中で生まれた例外（＝想定外の挙動）を検知する目的
                    //Password:MAMP='root',XAMPP=''
    $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');    //PHP Data Objects
    // $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれる。


  // ３．SQL文を用意(データ登録：INSERT)
  $stmt = $dbh->prepare(
    "SELECT membercode, name FROM member WHERE email= :member_email AND password= :member_pass"
    );

  // 4. バインド変数を用意
  $stmt->bindValue(':member_email', $member_email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':member_pass', $member_pass, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

  // 5. 実行
  $status = $stmt->execute();  

  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }

  
  //6．データ表示
  if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if($result == false){
      echo 'メールアドレスかパスワードが間違っています。<br />';
      echo '<a href="member_login.html">戻る</a>';
  }else{
      session_start();
      $_SESSION['member_login'] = 1;
      $_SESSION['member_code'] = $result['membercode']; 
      $_SESSION['membername'] = $result['name']; 
      header('Location:shop_list.php');
      exit();
  }
}
?>