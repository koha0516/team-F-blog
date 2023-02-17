<?php
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';


//投稿内容のフォーム受取⇒セッションに入力情報登録
if (isset($_POST['title'])) {
  $_SESSION['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES, "UTF-8");
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

//エラー変数初期化
$error=false;

$title = $_POST['title'];
$contents = $_POST['contents'];
$tag = $_POST['tag'];
$published = $_POST['publish'];

// エラーチェック
if (empty($_POST['title'])) {
  $error = true;
  $_SESSION['error_title'] = "タイトルは必須項目です";
} else if (!user_function::length_validation($_POST['title'], 60, 1)) {
  $error = true;
  $_SESSION['error_title'] = "タイトルは60文字以内です";
}
if (empty($_POST['contents'])) {
  $error = true;
  $_SESSION['error_contents'] = "記事の内容は必須項目です";
} else if (!user_function::length_validation($contents, 10000, 1)) {
  $error = true;
  $_SESSION['error_contents'] = "記事の内容は10000文字以内です";
}

if(empty($_POST['tag'])){
  $error=true;
  $_SESSION['error_tag']="タグは必須項目です";
}

//入力エラーがどこかで発生したらリダイレクトする
if ($error) {
  header('Location: post-form.php');
}
if(article_register($title, $contents, $tag, $userid, $published)){
  header('Location: ../index.php');
}
?>