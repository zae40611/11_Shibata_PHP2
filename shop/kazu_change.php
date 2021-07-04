<?php
    session_start();
    session_regenerate_id(true);

    require_once('../funcs.php');

    $max = h($_POST['max']);
    
    // var_dump($max);

    for($i=0; $i<$max; $i++){
        if(preg_match("/^[0-9]+$/",h($_POST['kazu'.$i]) == 0)){
            echo '数量に誤りがあります。半角英数となっているかご確認ください。<br />';
            echo '<a href="shop_cartlook.php">カートに戻る</a>';
            exit();            
        }

        if(h($_POST['kazu'.$i])<1 || 10<h($_POST['kazu'.$i])){
            echo '数量は必ず１個以上、10個までです。';
            echo '<a href="shop_cartlook.php">カートに戻る</a>';
            exit();
        }
        $kazu[] = h($_POST['kazu'.$i]);
    }
    // var_dump($kazu);

    $cart = $_SESSION['cart'];
    for($i = $max; 0<=$i; $i--){
        if(isset($_POST['delete'.$i]) == true){
            array_splice($cart,$i,1);
            array_splice($kazu,$i,1);
        }
    }
    $_SESSION['cart'] = $cart;
    $_SESSION['kazu'] = $kazu;


    header('Location:shop_cartlook.php');
    exit();


?>