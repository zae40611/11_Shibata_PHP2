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
$staffcode = $_GET['staffcode'];


// 2. DB接続
try {
  //Password:MAMP='root',XAMPP=''
  $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//3．SQL文を用意(データ取得：SELECT)
$stmt = $dbh->prepare("SELECT staffname FROM staff WHERE staffcode = $staffcode");

//4. 実行
$status = $stmt->execute();

//5．データ表示
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$staffname = $result['staffname'];

?>

スタッフ修正<br />
<br />
スタッフコード<br />
<?php echo $staffcode;?>
<br />
<br />
<form method="POST" action="staff_edit_check.php">
<input type="hidden" name="staffcode" value="<?php echo $staffcode; ?>">
スタッフ名<br />
<input type="text" name="staffname" style="width:200px" value="<?php echo $staffname; ?>"><br />
パスワードを入力してください。<br />
<input type="password" name="pass" style="width:100px"><br />
パスワードをもう一度入力してください。<br />
<input type="password" name="pass2" style="width:100px"><br />
<br />

<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>


</body>

