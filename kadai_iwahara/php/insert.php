<?php
//----------------------------------------------------
//１．入力チェック(受信確認処理追加)
//----------------------------------------------------
//商品名 受信チェック:item
if(!isset($_POST["naiyou"]) || $_POST["naiyou"]==""){
  exit("ParameError! naiyou!");
}

//金額 受信チェック:value


//商品紹介文 受信チェック:description
// if(!isset($_POST["description"]) || $_POST["description"]==""){
//   exit("ParameError! description!");
// }


//ファイル受信チェック※$_FILES["******"]["name"]の場合
// if(!isset($_FILES["fname"]["name"]) || $_FILES["fname"]["name"]==""){
//   exit("ParameError! FILES!");
// }




//----------------------------------------------------
//２. POSTデータ取得
//----------------------------------------------------
$naiyou   = $_POST["naiyou"];   //商品名


//1-2. FileUpload処理

//----------------------------------------------------
//３. DB接続します(エラー処理追加)
//----------------------------------------------------
try {
  $pdo = new PDO('mysql:dbname=kadai_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//----------------------------------------------------
//４．データ登録SQL作成
//----------------------------------------------------
$stmt = $pdo->prepare("INSERT INTO kadai_table(id, naiyou, indate
)VALUES(NULL, :naiyou,sysdate())");
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);

$status = $stmt->execute();

//----------------------------------------------------
//５．データ登録処理後
//----------------------------------------------------
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．item.phpへリダイレクト
  header("Location: index.html");
  exit;
}
?>
