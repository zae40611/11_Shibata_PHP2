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

スタッフが選択されていません。<br />
<a href="staff_list.php">戻る</a>

</body>

