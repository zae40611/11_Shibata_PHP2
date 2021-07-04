<body>

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

// 1. POSTデータ取得
$productcode = $_POST['productcode'];
$productname = $_POST['productname'];
$price = $_POST['price'];
$pictureoldname = $_POST['pictureoldname'];
$picturenewname = $_POST['picturenewname'];

$productcode = h($productcode);
$productname = h($productname);
$price = h($price);

if($picturenewname == ''){
  $picturename = $pictureoldname;
}else{
  $picturename = $picturenewname;
}

// 2. DB接続します
try {               //try-catch文  ロジック中で生まれた例外（＝想定外の挙動）を検知する目的
                    //Password:MAMP='root',XAMPP=''
    $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');    //PHP Data Objects
    // $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれる。
  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }

// ３．SQL文を用意(データ更新：UPDATE)
    $stmt = $dbh->prepare(
    "UPDATE product SET productname = :productname, price = :price, picture = :picturename WHERE productcode = :productcode"
    );

// 4. バインド変数を用意
    $stmt->bindValue(':productcode', $productcode, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':productname', $productname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':price', $price, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':picturename', $picturename, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  // if($pictureoldname != ''){
  //   unlink('./img/'.$pictureoldname);
  // }
  echo "修正しました。<br />";
}

?>
<br />
<a href="pro_list.php">戻る</a>

</body>