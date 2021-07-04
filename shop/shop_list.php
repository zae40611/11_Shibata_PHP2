<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
    echo 'ようこそ ゲスト様<br />';
    echo '<a href="member_login.html">会員ログイン画面へ</a>';
    echo '<br />';
}else{
    echo 'ようこそ ';
    echo $_SESSION['membername'];
    echo '様  ';
    echo '<a href="member_logout.php">ログアウト</a><br />';
    echo '<br />';
}


//funcs.phpを読み込む
require_once('../funcs.php');

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//２．SQL文を用意(データ取得：SELECT)
$stmt = $dbh->prepare("SELECT * FROM product");

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
  echo '商品一覧<br /><br />';
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 

    echo '<a href="shop_product.php?productcode='.h($result['productcode']).'">';
    echo h($result['productname']).'---';
    echo h($result['price']).'円';
    echo '</a>';
    echo '<br />';
  }

  echo '<br />';
  echo '<a href="shop_cartlook.php">カートを見る</a><br />';
  echo '<br />';
  echo '<a href="clear_cart.php">カートを空にする</a><br />';

}

?>
<body>
</body>