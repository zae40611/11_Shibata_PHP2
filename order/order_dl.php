<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['longin'])==false){
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

ダウンロードする年月を選択してください。<br>
<form method="post" action="order_dl_done.php">
    <select name="year" id="year"></select>年
    <select name="month" id="month"></select>月
    <br /><br />
<input type="submit" value="ダウンロード">
</form>


<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- JQuery -->
<script>
    let y = "";
    for(let i=2020; i<2022; i++){
        y += "<option value=" + i + ">" + i + "</option>"
    }         
    $("#year").html(y);

    let m = "";
    for(let i=1; i<13; i++){
        let j = ('00' + i).slice(-2);
        m += "<option value=" + j + ">" + i + "</option>"
    }         
    $("#month").html(m);
</script>
</body>

</html>