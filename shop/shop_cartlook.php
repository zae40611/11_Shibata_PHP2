<style>
table{
  border-collapse: collapse;
  border: 2px solid black;
  text-align: center;
}

td{
  border: 1px solid black;
}

</style>

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

$cart = $_SESSION['cart'];
$kazu = $_SESSION['kazu'];
$max = count($cart);

if($max == 0){
  echo '<br />';
  echo 'カートに商品が入っていません。<br />';
  echo '<br />';
  echo '<a href="shop_list.php">商品一覧へ戻る</a>';
  exit();
}


// var_dump($cart);


// 2. DB接続
try {
  //Password:MAMP='root',XAMPP=''
  $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');

  foreach($cart as $key => $val){
    $stmt = $dbh->prepare('SELECT productcode, productname, price, picture FROM product WHERE productcode = ?');
    $data[0] = $val;
    $stmt -> execute($data);

    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    $productname[]=$result['productname'];
    $price[]=$result['price'];
    if($result['picture']==''){
        $picture[] = '';
    }else{
        $picture[] = '<img src="../product/img/'.$result['picture'].'" style="width:100px">'; 
    }
  }
  $dbh = null;



} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}


?>

カートの中身<br />
<br />
<form method="post" action="kazu_change.php">
<table>
  <tr>
    <td>商品名</td>
    <td>商品画像</td>
    <td>価格</td>
    <td>数量</td>
    <td>小計</td>
    <td>削除</td>
  </tr>
  <?php for($i=0; $i<$max; $i++){  ?>
  <tr>
    <td> <?php    echo $productname[$i];  ?></td>
    <td> <?php    echo $picture[$i];      ?></td>
    <td> <?php    echo $price[$i].'円';    ?></td>
    <!-- <td> <?php    echo $kazu[$i];         ?></td> -->
    <td> <input type="text" name="kazu<?php echo $i;?>" value="<?php echo $kazu[$i];?>" style="width: 50px; text-align:right"> </td>
    <td> <?php echo $price[$i]*$kazu[$i];?> 円</td>
    <td> <input type="checkbox" name="delete<?php echo $i;?>"></td>  
  </tr>
    <?php $total += $price[$i]*$kazu[$i]; ?>

  <?php  }                         ?>
</table>  
    <?php    echo '<br />';          ?>
<?php echo '合計；'.$total ; ?>円  <br />
<br />


<input type="hidden" name="max" value="<?php echo $max;?>">
<input type="submit" value="数量変更・商品削除"><br />
<a href="shop_list.php">商品一覧に戻る</a><br />
<input type="button" onclick="history.back()" value="戻る">
</form>
<br />
<a href="shop_form.html">ご購入手続きに進む</a><br />


<?php
  if(isset($_SESSION['member_login'])==true){
    echo '<a href="shop_memberorder_check.php">会員の方はこちらから購入手続きをお願いします。</a><br/>';
  }
?>

</body>

