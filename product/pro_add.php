<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品追加</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
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
?>

<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
    <!-- <a class="navbar-brand" href="select.php">データ一覧</a></div> -->
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="pro_add_check.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>商品追加</legend>
     <label>商品名：<input type="text" name="productname"></label><br>
     <label>価格：<input type="text" name="price"></label><br>
     <label>画像：<input type="file" name="picture" style="width:400px"></label><br>
     <button type="button" onclick="history.back()">戻る</button>
     <input type="submit" value="OK">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
