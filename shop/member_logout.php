<?php
session_start();
$_SESSION=array();
if(isset($_COOKIE[session_name()])==true){
    setcookie(session_name(),'', time()-42000,'/');
}
session_destroy();

?>
<body>
    ログアウトしました。<br />
    <br />
    <a href="./shop_list.php">商品一覧へ</a>
</body>

