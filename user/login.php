<?php
session_start();
//ログイン実行ファイル読み込み
require_once '../DB/user_dao.php';

//エラー変数初期化
$error = false;

//フォームの値受け取り
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8");
$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, "UTF-8");

// 値が入っているかチェック
if (empty($name)) {
  $error = true;
  $_SESSION['error_name'] = "メールアドレスを入力してください";
}
if (empty($pass)) {
  $error = true;
  $_SESSION['error_pass'] = "パスワードを入力してください";
}

//入力エラーがどこかで発生したらリダイレクトする
if ($error) {
  header('Location: login-form.php');
}

//ソルトとハッシュ後のパスワードをDBから取得する
$salt = get_salt($name);
//   ハッシュ化
$password = hash('sha256', $pass . $salt);
//   mailとハッシュ化したpwを元にアカウント情報の取得
$res = login($name, $password);
//   $resの中身が空じゃなければ成功
//   セッション配列user_infoにデータを格納
if (!empty($res)) {
  $_SESSION['user_info'] = $res;
  //ログイン成功したらログイン後ホームに飛ぶ
  header('Location: ../');
}
