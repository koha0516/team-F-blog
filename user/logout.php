<?php
session_start();
//セッションの破棄
$_SESSION = [];
if(isset($_COOKIE[session_name()])){
  setcookie(session_name(),'',time() -1800);
}
session_destroy();

//ログイン前ページに飛ぶ
//header('Location: ../index.php');
