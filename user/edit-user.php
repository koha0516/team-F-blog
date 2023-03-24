<?php
session_start();
require_once '../DB/user_dao.php';
require_once '../function/user_function.php';


//フォームの入力値を受け取って、セッションにユーザ情報を格納（パスワード以外）
if (isset($_POST['name'])) {
  $_SESSION['name'] = htmlspecialchars(trim($_POST['name'], "\x20\t\n\r\0\v  "), ENT_QUOTES, "UTF-8");
}

if (isset($_POST['mail'])) {
  $_SESSION['mail'] = htmlspecialchars($_POST['mail'], ENT_QUOTES, "UTF-8");
}

//エラー変数初期化
$error = false;

$name = $_SESSION['name'];
$mail = $_SESSION['mail'];

// エラーチェック
if (empty($name)) {
  $error = true;
  $_SESSION['error_name'] = "名前は必須項目です";
} else if (!user_function::length_validation($name, 60, 1)) {
  $error = true;
  $_SESSION['error_name'] = "名前は60文字以内です";
}

if (empty($mail)) {
  $error = true;
  $_SESSION['error_mail'] = "メールアドレスを入力してください";
}else if(!user_function::mail_validation($mail)){
  $_SESSION['error_mail'] = "メールアドレスが間違っています";
}

//入力エラーがどこかで発生したらリダイレクトする
if ($error) {
  header('Location: edit-user-form.php');
}

//sql実行
if (edit_user($_SESSION['user_info']['user_id'] ,$name, $mail)) {
  header('Location: my-page.php');
  $_SESSION['user_info']['user_name'] = $name;
  $_SESSION['user_info']['user_mail'] = $mail;
} else {
  header('Location: edit-user-form.php');
}

