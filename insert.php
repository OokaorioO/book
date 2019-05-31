<?php
// exit('error');処理を止める
//入力チェック
if (
    !isset($_POST['name']) || $_POST['name']=='' ||
    !isset($_POST['url']) || $_POST['url']==''
) {
    exit('paramError');
}
// } else {
//     var_dump($_POST);
//     exit();
// }

//POSTデータ取得
$name = $_POST['name'];
$url = $_POST['url'];
$checkbox=$_POST['checkbox'];
$comment = $_POST['comment'];




// DB接続
$dbn = 'mysql:dbname=gsf_l01_db14;cherset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = 'root';

try {
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    exit('dbError:'.$e->getMessage());
}

// //データ登録SQL作成
$sql ='INSERT INTO gs_bm_table(id,name,url,comment,checkbox,indate)VALUES(NULL, :a, :b, :c, :d, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':b', $url, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':c', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':d', $checkbox, PDO::PARAM_STR);
$status = $stmt->execute();
// exit('error');
// //４．データ登録処理後
if ($status==false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location:index.php');
}

if (empty($_GET["checkbox"])) {
    echo "何も選んでません";
} else {
    $checkbox = $_GET["checkbox"];
    $checkbox = array(1 => "Amazon", 2 => "Twitter", 3 => "Facebook",4 => "その他");
    echo $checkbox[$checkbox]."を選びました。";
}
