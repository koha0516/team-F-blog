<?php
session_start();

$url = 'http://localhost/php_demo/team-F-blog/user/edit-password.php';
$auth = uniqid();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
if (isset($_SESSION['user_info'])) {
  $user = $_SESSION['user_info'];
  $to = $user['user_mail'];
}
$title = "パスワードの変更について";
$content = "以下のURLをクリックしてパスワードを変更してください\n".$url."?auth=".$auth;
$headers = "From: ".$to;
if(mb_send_mail($to, $title, $content, $headers)){
  echo "メールを送信しました";
} else {
  echo "メールの送信に失敗しました";
};
