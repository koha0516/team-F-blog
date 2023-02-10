<?php
// データベースに接続する準備

// ユーザ名
$user = "root";
// パスワード
$pass = "";
// データベース名
$database = "blog_app";
// サーバ名
$server = "localhost:3308";

// DSN文字列の生成
$dsn = "mysql:host={$server};dbname={$database};charset=utf8";

// mysqlデータベースへの接続
try{
  // PDOクラスのインスタンスを作成してDBに接続
  $pdo = new PDO($dsn, $user, $pass);
  // プリペアドステートメントのエミュレーションの無効化
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
  // 例外がスローされつ用にする
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  echo "データベースに接続しました";
}catch(Exception $e){
  echo "DB接続エラー";
  echo $e->getMessage();
  exit();
}
