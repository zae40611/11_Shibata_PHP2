<?php

session_start();
session_regenerate_id(true);


try {
    require_once('../funcs.php');

    $shimei  = h($_POST['shimei']);
    $email   = h($_POST['email']);
    $postal1 = h($_POST['postal1']);
    $postal2 = h($_POST['postal2']);
    $address = h($_POST['address']);
    $tel     = h($_POST['tel']);
    $order   = h($_POST['order']);
    $pass    = h($_POST['pass']);
    $sex     = h($_POST['sex']);
    $birth   = h($_POST['birth']);

    echo $shimei.'様<br />';
    echo 'ご注文ありがとうございました。<br />';
    echo $email.'にメールを送りましたのでご確認ください。<br />';
    echo '商品は以下の住所に発送させて頂きます。<br />';
    echo $postal1.'-'.$postal2.'<br />';
    echo $address.'<br />';
    echo $tel.'<br />';

    $honbun = '';
    $honbun .= $shimei."様<br />この度はご注文ありがとうございました。<br /><br />";
    $honbun .= "ご注文商品<br />";
    $honbun .= "------------------------------<br />";

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);
    // var_dump($cart) ;
    // echo $cart[0];
    // echo $cart[1];
    // echo $cart[2];
    // echo $max;

    $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    for($i=0; $i<$max; $i++){
      $stmt = $dbh->prepare('SELECT productname, price FROM product WHERE productcode = '.$cart[$i].'');
      // $data[0] =$cart[$i];
      $stmt -> execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $name = $result['productname'];
      $price = $result['price'];
      $kakaku[] = $price;  // この１文は、後段のSales DB INSERT 用に価格を配列に入れる為のスクリプト。
      $amount = $kazu[$i];
      $shoukei = $price * $amount;
      $total += $price*$amount;

      $honbun .= $name.'';
      $honbun .= $price.'円 x';
      $honbun .= $amount.'個 =';
      $honbun .= $shoukei.'円 <br />';
    }

    //////////////データテーブル追加時に他人が横から入り込まない様にするロック機能//////////////
    $stmt = $dbh -> prepare('LOCK TABLES sales WRITE, sales_details WRITE, member WRITE');
    $stmt -> execute(); 

    //////////////会員データのDB登録//////////////
    $lastmembercode=0;
    if($order == 'memberreg'){
      if($sex == 'male'){
        $sexy = 1;
      }else{
        $sexy = 2;
      }

      $stmt = $dbh->prepare(
        "INSERT INTO member ( membercode, indate, password, name, email, postal1, postal2, address, tel, sex, birth)
        VALUES( NULL, sysdate(), :pass, :shimei, :email, :postal1, :postal2, :address, :tel, :sexy, :birth)"
        );

        $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':shimei', $shimei, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':postal1', $postal1, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':postal2', $postal2, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':sexy', $sexy, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':birth', $birth, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        
        $stmt -> execute();
        $stmt = $dbh ->prepare('SELECT LAST_INSERT_ID()');
        $stmt -> execute();
        $result = $stmt -> fetch(PDO::FETCH_ASSOC);
        $lastmembercode = $result['LAST_INSERT_ID()'];
      }



    //////////////Sale DBに売上データを入れる//////////////
    $stmt = $dbh->prepare(
    "INSERT INTO sales ( customercode, indate, code_member, customername, email, postal1, postal2, address, tel)
    VALUES( NULL, sysdate(), '$lastmembercode', :shimei, :email, :postal1, :postal2, :address, :tel)"
    );

    $stmt->bindValue(':shimei', $shimei, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':postal1', $postal1, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':postal2', $postal2, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

    $stmt -> execute();

    
    $stmt = $dbh -> prepare('SELECT LAST_INSERT_ID()');
    $stmt -> execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    $lastcode = $result['LAST_INSERT_ID()'];
    // echo $lastcode;
    for($i=0; $i<$max; $i++){
      $stmt = $dbh->prepare(
        "INSERT INTO sales_details (detailcode, salescode, productcode, price, quantity)
        VALUES( NULL, :lastcode, '$cart[$i]', '$kakaku[$i]', '$kazu[$i]')"
        );
        $stmt->bindValue(':lastcode', $lastcode, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

      $stmt -> execute();
    }

    //////////////ロック機能解除//////////////
    $stmt = $dbh -> prepare('UNLOCK TABLES');
    $stmt -> execute(); 

    $dbh = null;

    
    //////////////会員登録完了通知//////////////
    if($order == 'memberreg'){
      echo'会員登録が完了しました。<br />';
      echo'次回からメールアドレスとパスワードでログインしてください。<br />';
      echo'ご注文が簡単にできるようになります。<br /><br />';
    }
    //////////////    おわり    //////////////


      $honbun .= '合計：';
      $honbun .= $total.'円 <br />';
      $honbun .= "送料は無料です。<br />";
      $honbun .= "------------------------------<br /><br />";
      $honbun .= "代金は以下の口座にお振り込みください。<br />";
      $honbun .= "●●銀行  ●●支店 普通123456 <br />";
      $honbun .= "入金確認次第、発送いたします。<br /><br />";

    //////////////会員登録完了通知＜メール＞//////////////
    if($order == 'memberreg'){
      $honbun .= '会員登録が完了しました。<br />';
      $honbun .= '次回からメールアドレスとパスワードでログインしてください。<br />';
      $honbun .= 'ご注文が簡単にできるようになります。<br /><br />';
    }
    ////////////////////    おわり    /////////////////////

      $honbun .= "柴田博之<br />";


      // echo '<br />';
      // echo nl2br($honbun);

      $title = 'ご注文ありがとうございます。';
      $header = 'From: hiroyuki.shibata@mitsubishicorp.com';
      $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
      mb_language('Japanese');
      mb_internal_encoding('UTF-8');
      mb_send_mail($email, $title, $honbun, $header);

      $title = 'お客様からご注文がありました。';
      $header = 'From:'.$email;
      $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
      mb_language('Japanese');
      mb_internal_encoding('UTF-8');
      mb_send_mail('hiroyuki.shibata@mitsubishicorp.com', $title, $honbun, $header);

      // echo $honbun;

  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }

echo '<br />';
echo '<a href="shop_list.php">商品一覧へ</a>';

?>
