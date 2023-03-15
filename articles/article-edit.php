<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';

//バリデーションチェック用クラスの読み込み
require_once '../function/user_function.php';


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
$userid="";
$user=[];
if (isset($_SESSION['user_info'])){
  $user = $_SESSION['user_info']; 
  $userid=$user['user_id'];
}

$error=false;

$title = $_SESSION['title'];
$contents = $_SESSION['contents'];
$tag = $_SESSION['tag'];
if (isset($_SESSION['publish'])) {
  $published = 1;
} else {
  $published = 0;
}
$articleid=$_SESSION['article_id'];

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
  header('Location: user-edit-form.php');
}

//アップデート
if(update_article($title, $contents, $tag, $userid, $published, $articleid)){
  header('Location: ../user/my-page.php');
}
?>