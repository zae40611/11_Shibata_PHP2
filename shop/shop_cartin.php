<body>
    
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
    echo 'ようこそゲスト様<br />';
    echo '<a href="member_login.html">会員ログイン画面へ</a>';
    echo '<br />';
}else{
  echo 'ようこそ';
  echo $_SESSION['membername'];
  echo '様  ';
  echo '<a href="member_logout.php">ログアウト</a><br />';
  echo '<br />';
}

//funcs.phpを読み込む
require_once('../funcs.php');

// 1. POSTデータ取得
$productcode = $_GET['productcode'];


// 2. DB接続
try {
// $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');  
$cart = $_SESSION['cart'];
$kazu = $_SESSION['kazu'];

if(in_array($productcode, $cart) == true){
  echo '<br />';
  echo 'その商品はすでにカートに入っています。<br />';
  echo '<br />';
  echo '<a href="shop_cartlook.php">こちら</a>をクリックして数量の変更をお願いします。<br />  ';
  echo '<br />';
  echo '<a href="shop_list.php">商品一覧に戻る</a>';
  exit();
}

$cart[]=$productcode;
$kazu[] = 1;
$_SESSION['cart'] = $cart;
$_SESSION['kazu'] = $kazu;



// foreach($cart as $key => $val){  //チェックのためのEchoだったので、確認できたら削除
//   echo $val;
//   echo '<br />';
// }

} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

// //3．SQL文を用意(データ取得：SELECT)
// $stmt = $dbh->prepare("SELECT productname, price, picture FROM product WHERE productcode = $productcode");

// //4. 実行
// $status = $stmt->execute();

// //5．データ表示
// $result = $stmt->fetch(PDO::FETCH_ASSOC);
// $productname = $result['productname'];
// $price = $result['price'];
// $picturename = $result['picture'];

// if($picturename == ''){
//     $disp_picture='';
// }else{
//     $disp_picture='<img src="../product/img/'.$picturename.'" style="width:100px">';
// }


?>

カートに追加しました。<br />
<br />
<a href="shop_cartlook.php">カートを見る</a>
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>

