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
$stmt = $dbh->prepare("SELECT productname,price,picture FROM product WHERE productcode = $productcode");

//4. 実行
$status = $stmt->execute();

//5．データ表示
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$productname = $result['productname'];
$price = $result['price'];
$pictureoldname = $result['picture'];

if($pictureoldname == ''){
  $disp_picture ='';
}else{
  $disp_picture ='<img src="./img/'.$pictureoldname.'" style="width:100px">';
}

?>

商品修正<br />
<br />
商品コード<br />
<?php echo $productcode;?>
<br />
<br />
<form method="POST" action="pro_edit_check.php" enctype="multipart/form-data">
<input type="hidden" name="productcode" value="<?php echo $productcode; ?>">
<input type="hidden" name="pictureoldname" value="<?php echo $pictureoldname; ?>">
商品名<br />
<input type="text" name="productname" style="width:200px" value="<?php echo $productname; ?>"><br />
価格<br />
<input type="text" name="price" style="width:50px" value="<?php echo $price; ?>">円<br />
<br />
<?php echo $disp_picture;?>
<br />
画像を選んでください。<br />
<input type="file" name="picturenewname"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>


</body>

