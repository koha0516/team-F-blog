<?php
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';

echo "<pre>";
echo var_dump($_POST);
echo "</pre>";

//投稿内容のフォーム受取⇒セッションに入力情報登録
if (isset($_POST['title'])) {
  $_SESSION['title'] = htmlspecialchars(trim($_POST['title'], "\x20\t\n\r\0\v  "), ENT_QUOTES, "UTF-8");
}
if (isset($_POST['contents'])) {
  $_SESSION['contents'] = htmlspecialchars($_POST['contents'], ENT_QUOTES, "UTF-8");
}
if (isset($_POST['tag'])) {
  $_SESSION['tag'] = $_POST['tag'];
}
if (isset($_POST['publish'])) {
  $_SESSION['publish'] = $_POST['publish'];
}

//エラー変数初期化
$error = false;


$title = $_SESSION['title'];
$contents = $_SESSION['contents'];
$tag = $_SESSION['tag'];
$publish = $_SESSION['publish'];
$user = $_SESSION['user_info'];

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
  header('Location: index.php');
}

$user = $_SESSION['user_info'];

?>