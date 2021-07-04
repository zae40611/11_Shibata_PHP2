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

//funcs.phpを読み込む
require_once('funcs.php');

// 1. POSTデータ取得
$productcode = $_GET['productcode'];


// 2. DB接続
try {
  //Password:MAMP='root',XAMPP=''
  $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//3．SQL文を用意(データ取得：SELECT)
$stmt = $dbh->prepare("SELECT productname, price, picture FROM product WHERE productcode = $productcode");

//4. 実行
$status = $stmt->execute();

//5．データ表示
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$productname = $result['productname'];
$price = $result['price'];
$picturename = $result['picture'];

if($picturename == ''){
    $disp_picture='';
}else{
    $disp_picture='<img src="./img/'.$picturename.'" style="width:100px">';
}


?>

商品情報参照<br />
<br />
商品コード<br />
<?php echo $productcode;?>
<br />
商品名<br />
<?php echo $productname;?>
<br />
価格<br />
<?php echo $price;?>円
<br />
<?php echo $disp_picture;?>
<br />
<br />
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>


</body>

