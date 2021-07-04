<?php
require_once('funcs.php');

session_start();
session_regenerate_id(true);  //合言葉を変更する関数
if(isset($_SESSION['login'])==false){
    echo 'ログインされていません。<br />';
    echo '<a href="./staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}else{
    echo $_SESSION['staffname'];
    echo 'さんログイン中<br />';
    echo '<br />';
}


?>

<body>
    
ショップ管理トップメニュー<br />
<br />
<a href="./staff/staff_list.php">スタッフ管理</a>
<br />
<a href="./product/pro_list.php">商品管理</a>
<br />
<a href="./order/order_dl.php">注文履歴ダウンロード</a>
<br />
<a href="./staff_login/staff_logout.php">ログアウト</a><br />
<br /><br />
<a href="./shop/shop_list.php">店舗トップページ(商品一覧)</a><br />

</body>

