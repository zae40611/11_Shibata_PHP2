

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


//funcs.phpを読み込む
require_once('funcs.php');

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//２．SQL文を用意(データ取得：SELECT)
$stmt = $dbh->prepare("SELECT * FROM staff");

//3. 実行
$status = $stmt->execute();

//4．データ表示
// $view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  echo 'スタッフ一覧<br /><br />';
  echo '<form method="post" action="staff_branch.php">';
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    // $view .= "<p>";
    // $view .= $result['staffname'];
    // $view .= "</p>";
    echo '<input type="radio" name="staffcode" value="'.h($result['staffcode']).'">';
    echo h($result['staffname']);
    echo '<br />';
  }
echo '<input type="submit" name="disp" value="参照">';
echo '<input type="submit" name="add" value="追加">';
echo '<input type="submit" name="edit" value="修正">';
echo '<input type="submit" name="delete" value="削除">';
echo '</form>';

}

?>
<body>
  
<br />
<a href="../staff_top.php">トップメニューへ</a> <br />

  </body>