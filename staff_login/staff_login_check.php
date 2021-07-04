<?php

require_once('../funcs.php');

// 1. POSTデータ取得
$staffcode = $_POST['code'];
$staffpass = $_POST['pass'];

$staffcode = h($staffcode);
$staffpass = h($staffpass);

$staffpass=md5($staffpass);

// 2. DB接続します
try {               //try-catch文  ロジック中で生まれた例外（＝想定外の挙動）を検知する目的
                    //Password:MAMP='root',XAMPP=''
    $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');    //PHP Data Objects
    // $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれる。
  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }

  // ３．SQL文を用意(データ登録：INSERT)
  $stmt = $dbh->prepare(
    "SELECT staffname FROM staff WHERE staffcode= :staffcode AND password= :staffpass"
    );

  // 4. バインド変数を用意
  $stmt->bindValue(':staffcode', $staffcode, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':staffpass', $staffpass, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

  // 5. 実行
  $status = $stmt->execute();  

  //6．データ表示
  if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if($result == false){
      echo 'スタッフコードかパスワードが間違っています。<br />';
      echo '<a href="staff_login.html">戻る</a>';
  }else{
      session_start();
      $_SESSION['login'] = 1;
      $_SESSION['staffcode'] = $staffcode; 
      $_SESSION['staffname'] = $result['staffname']; 
      header('Location:../staff_top.php');
      exit();
  }
}
?>