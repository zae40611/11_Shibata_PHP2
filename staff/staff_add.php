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

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>スタッフ登録</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
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
<form method="POST" action="staff_add_check.php">
  <div class="jumbotron">
   <fieldset>
    <legend>スタッフ追加</legend>
     <label>名前：<input type="text" name="staffname"></label><br>
     <label>パスワード：<input type="password" name="pass"></label><br>
     <label>パスワード(確認用)：<input type="password" name="pass2"></label><br>
     <button type="button" onclick="history.back()">戻る</button>
     <input type="submit" value="OK">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
