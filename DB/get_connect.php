<?php

function get_connect() {
  //ユーザー名
  $user = "grant_all_user";
  //パスワード
  $pass = "T4tZhGD-GRUfDtUgF6";
  //データベース名
  $database = "weather_act";
  //サーバー
  $server = "127.0.0.1:3308";

  //DSN文字列の生成
  $dsn = "mysql:host={$server};dbname={$database};charset=utf8";

  //mysqlデータベースへの接続
  try {
    //PDOのインスタンスを作成し、DBへ接続する
    $pdo = new PDO($dsn, $user, $pass);
    //プリペアドステートメントのエミュレーションを無効化
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //      echo "データベースに接続しました";
    return $pdo;
  } catch (Exception $e) {
    echo "DB接続エラー";
    echo $e->getMessage();
    exit();
  }
}
