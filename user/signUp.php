<?php
session_start();
require_once '../DB/user_dao.php';
require_once '../function/user_function.php';


//フォームの値受取⇒セッションにユーザ情報登録（パスワード以外）
if (isset($_POST['name'])) {
  $_SESSION['name'] = htmlspecialchars(trim($_POST['name'], "\x20\t\n\r\0\v  "), ENT_QUOTES, "UTF-8");
}
if (isset($_POST['birth'])) {
  $_SESSION['birth'] = $_POST['birth'];
}
if (isset($_POST['mail'])) {
  $_SESSION['mail'] = htmlspecialchars($_POST['mail'], ENT_QUOTES, "UTF-8");
}

//エラー変数初期化
$error = false;

$name = $_SESSION['name'];
$birth = $_SESSION['birth'];
$mail = $_SESSION['mail'];

// エラーチェック
if (empty($name)) {
  $error = true;
  $_SESSION['error_name'] = "名前は必須項目です";
} else if (!user_function::length_validation($name, 60, 1)) {
  $error = true;
  $_SESSION['error_name'] = "名前は60文字以内です";
}

if (empty($birth)) {
  $error = true;
  $_SESSION['error_birth'] = "生年月日を入力してください";
} else if (!user_function::age_validation($birth)) {
  $error = true;
  $_SESSION['error_birth'] = "13歳未満は利用できません";
}

if (empty($mail)) {
  $error = true;
  $_SESSION['error_mail'] = "メールアドレスを入力してください";
}else if(!user_function::mail_validation($mail)){
  $_SESSION['error_mail'] = "メールアドレスが間違っています";
}

if (empty($_POST['pass1'])) {
  $error = true;
  $_SESSION['error_pass'] = "パスワードを入力してください";
} else if ($_POST['pass1'] !== $_POST['pass2']) {
  $error = true;
  $_SESSION['error_pass'] = "パスワードが間違っています";
}else if (!user_function::pw_validation($_POST['pass1'])) {
  $error = true;
  $_SESSION['error_pass'] = "パスワードが間違っています";
}

//入力エラーがどこかで発生したらリダイレクトする
if ($error) {
  header('Location: signUp-form.php');
}

$pass = htmlspecialchars($_POST['pass2'], ENT_QUOTES, "UTF-8");
//20桁のソルト生成
$salt = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 20);
$password = hash('sha256', $pass . $salt);

//sql実行
if (user_register($name, $birth, $mail, $salt, $password)) {
  $_SESSION['user_info'] = login($name, $password);
  header('Location: #');
} else {
  header('Location: signUp-form.php');
}
