<?php






?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品一覧</title>
  <style>
        html {
            font-size: 62.5%;
        }

        .nav{
            height: 10vh;  /* 縦幅スクリーンの80％*/
            width: 70vw;   /* 横幅スクリーンの70％*/
            background-color: lightgray;
            border: 1px;
            border-color: gray;
            margin: auto;
            font-size: 1.5rem;
            display: flex;         

        }
        .outer{
            height: 80vh;  /* 縦幅スクリーンの80％*/
            width: 70vw;   /* 横幅スクリーンの70％*/
            background-color: lightblue;
            border: 1px;
            border-color: blue;
            margin:  auto;
            display: grid;
            grid-template-rows: 10% 80% 10%;
            grid-template-columns: 100%;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;

        }
        .guestname{
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        } 
        .memberlogin{
            width: 50%;
            /* text-align: right; */
            /* padding-right: 10px; */
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;

        }
        .list{
            text-align: center;
            grid-row: 1 / 2;
            /* grid-column: 1 / 6; */
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card{
            width: 100%;
            height: 100%;
            grid-row: 2 / 3;
            /* grid-column: 1 / 6; */
            display: grid;
            grid-template-rows: 1fr 1fr 1fr;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
            justify-content: center;
            align-items: center; 
        }
        .picbox{
            text-align: center;
        }
        .footer{
            grid-row: 3 / 4;
            /* grid-column: 1 / 6; */
            text-align: center;
            font-size: 1.5rem;
        }

  </style>
</head>
<body>
<div class="nav">
    <?php
    session_start();
    session_regenerate_id(true);
    if(isset($_SESSION['member_login'])==false){
        echo '<div class="guestname">ようこそ ゲスト様</div>';
        echo '<div class="memberlogin"><a href="member_login.html">会員ログイン画面へ</a></div>';
        // echo '<br />';
    }else{
        echo '<div class="guestname">ようこそ ';
        echo $_SESSION['membername'];
        echo '様</div>  ';
        echo '<div class="memberlogin"><a href="member_logout.php">ログアウト</a></div>';
        // echo '<br />';
    }
    ?>
</div>
<div class="outer">
  <?php 
        //funcs.phpを読み込む
      require_once('../funcs.php');

      //1.  DB接続します
      try {
        //Password:MAMP='root',XAMPP=''
        $dbh = new PDO('mysql:dbname=kadai08;charset=utf8;host=localhost','root','root');
      } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
      }

      //２．SQL文を用意(データ取得：SELECT)
      $stmt = $dbh->prepare("SELECT * FROM product");

      //3. 実行
      $status = $stmt->execute();

      //4．データ表示
      // $view="";
      if($status==false) {
        //execute（SQL実行時にエラーがある場合）
      $error = $stmt->errorInfo();
      exit("ErrorQuery:".$error[2]);

      }else{ 
      //Selectデータの数だけ自動でループしてくれる
      //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
        echo '<div class="list">鬼滅カード</div>';
        echo '<div class="card">';
      while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        echo '<div class="picbox"><img src="../product/img/'.h($result['picture']).'" style="height:75px; width:75px"><br />';
        echo '<a href="shop_product.php?productcode='.h($result['productcode']).'">';
        echo h($result['productname']).'--';
        echo h($result['price']).'円';
        echo '</a>';
        echo '</div>';
      }
      echo '</div>';

      echo '<div class="footer"><a href="shop_cartlook.php">カートを見る</a><br>';

      echo '<a href="clear_cart.php">カートを空にする</a></div>';

      }
  ?>
</div>

</body>
</html>