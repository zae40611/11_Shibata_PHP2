<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
    echo 'ログインされていません。<br />';
    echo '<a href="./staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}else{
    echo $_SESSION['staffname'];
    echo 'さんログイン中<br />';
    echo '<br />';
}

require_once('../funcs.php');

try {
    $year = h($_POST['year']);
    $month = h($_POST['month']);
    // echo ($year);
    // echo ($month);
    $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql =' SELECT
            sales.customercode,
            sales.indate,
            sales.code_member,
            sales.customername,
            sales.email,
            sales.postal1,
            sales.postal2,
            sales.address,
            sales.tel,
            sales_details.productcode,
            product.productname,
            sales_details.price,
            sales_details.quantity
        FROM
            sales, sales_details, product
        WHERE
            sales.customercode = sales_details.salescode AND
            sales_details.productcode = product.productcode AND
            substr(sales.indate,1,4) = '.$year.'  AND
            substr(sales.indate,6,2) = '.$month.'
        ';
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

        $dbh = null;

        $csv = '注文コード,注文日時,会員番号,氏名,メール,郵便番号,住所,電話番号,商品コード,商品名,価格,数量'."¥r";
        // $csv .= "¥r";
        while(true){
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);
            if($result == false){
                break;
            }
            $csv .= $result['customercode'];
            $csv .= ',';
            $csv .= $result['indate'];
            $csv .= ',';
            $csv .= $result['code_member'];
            $csv .= ',';
            $csv .= $result['customername'];
            $csv .= ',';
            $csv .= $result['email'];
            $csv .= ',';
            $csv .= $result['postal1'].'-'.$result['postal2'];
            $csv .= ',';
            $csv .= $result['address'];
            $csv .= ',';
            $csv .= $result['tel'];
            $csv .= ',';
            $csv .= $result['productcode'];
            $csv .= ',';
            $csv .= $result['productname'];
            $csv .= ',';
            $csv .= $result['price'];
            $csv .= ',';
            $csv .= $result['quantity']."¥r";
            // $csv .= "¥r";
        }

        echo nl2br($csv);
        
        $file = fopen('chumon.csv','w');
        fputs($file, $csv);
        fclose($file);

        echo '<br /><a href="chumon.csv">注文データのダウンロード</a><br />';
        echo '<a href="order_dl.php">日付選択画面へ戻る</a><br />';
        echo '<a href="../staff_top.php">トップメニューへ</a> <br />';
} catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
}

?>