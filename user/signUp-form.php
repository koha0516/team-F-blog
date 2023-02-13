<?php
session_start();

// htmlプレースホルダのための変数
$name = "";
$birth = "";
$mail = "";

//セッションに値が入っていたらセットする
if (isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
}
if (isset($_SESSION['birth'])) {
  $birth = $_SESSION['birth'];
}
if (isset($_SESSION['mail'])) {
  $mail1 = $_SESSION['mail'];
}


//名前入力エラーがあった場合はエラーメッセージを表示する
if (isset($_SESSION['error_name'])) {
  echo "<script>alert('" . $_SESSION['error_name'] . "')</script>";
}
if (isset($_SESSION['error_birth'])) {
  echo "<script>alert('" . $_SESSION['error_birth'] . "')</script>";
}
if (isset($_SESSION['error_mail'])) {
  echo "<script>alert('" . $_SESSION['error_mail'] . "')</script>";
}
if (isset($_SESSION['error_pass'])) {
  echo "<script>alert('" . $_SESSION['error_pass'] . "')</script>";
}

?>

<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<form action="signUp.php" method="post">
  <input type="text" name="name" placeholder="名前" value="<?php echo $name; ?>"><br>
  <input type="date" name="birth" value="<?php echo $birth; ?>"><br>
  <input type="text" name="mail" placeholder="メール" value="<?php echo $mail; ?>"><br>
  <input type="password" name="pass1" placeholder="パスワード"><br>
  <input type="password" name="pass2" placeholder="パスワードの再入力"><br>

  <a href="#">戻る</a>
  <input type="submit" value="登録する">
</form>
</body>
</html>