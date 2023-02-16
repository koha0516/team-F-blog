<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';

//バリデーションチェック用クラスの読み込み
require_once '../function/user_function.php';


//投稿フォームの入力値を受け取って、セッションに格納する
if (isset($_POST['title'])) {
  $_SESSION['title'] = htmlspecialchars(trim($_POST['title'], "\x20\t\n\r\0\v  "), ENT_QUOTES, "UTF-8");
}
if (isset($_POST['contents'])) {
    $_SESSION['contents'] = htmlspecialchars($_POST['contents'],ENT_QUOTES,"UTF-8");
}
if (isset($_POST['tag'])) {
  $_SESSION['tag'] = $_POST['tag'];
}
if (isset($_POST['publish'])) {
  $_SESSION['publish'] = $_POST['publish'];
}
if (isset($_SESSION['user_info'])){
    $user = $_SESSION['user_info']; 
    $userid=$user['user_id'];
}


//エラー変数初期化
$error=false;

$title = $_SESSION['title'];
$contents = $_SESSION['contents'];
$tag = $_SESSION['tag'];
$published = $_SESSION['publish'];

// エラーチェック
if (empty($title)) {
  $error = true;
  $_SESSION['error_title'] = "タイトルは必須項目です";
} else if (!user_function::length_validation($title, 60, 1)) {
  $error = true;
  $_SESSION['error_title'] = "タイトルは60文字以内です";
}
if (empty($contents)) {
  $error = true;
  $_SESSION['error_contents'] = "記事の内容は必須項目です";
} else if (!user_function::length_validation($contents, 10000, 1)) {
  $error = true;
  $_SESSION['error_contents'] = "記事の内容は10000文字以内です";
}

//入力エラーがどこかで発生したらリダイレクトする
if ($error) {
  header('Location: post-form.php');
}

//登録が成功したら投稿内容に関するセッションを空にして、ページ遷移する
if(article_register($title, $contents, $tag, $userid, $published)){
  $_SESSION['title']="";
  $_SESSION['contents']="";
  $_SESSION['tag']="";
  $_SESSION['publish']="";
  header('Location: ../user/mypage.php');
}
?>