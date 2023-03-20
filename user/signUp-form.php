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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/account_style.css">
  <title>ミジンコ|新規登録</title>
</head>
<body>

<header>
  <a href="/"><h1>ミジンコ</h1></a>
  <nav class="pc-nav">
    <ul>
      <li class="btn"><a href="login-form.php">ログイン</a></li>
      <li class="btn"><a href="signUp-form.php">新規登録</a></li>
    </ul>
  </nav>
</header>

<!--コンテンツ-->
<div class="box">
  <h2>新規登録</h2>
  <form action="signUp.php" method="post">

    <div class="cp_iptxt">
      <label class="ef">
        <input type="text" name="name" placeholder="お名前">
      </label>
    </div>

    <div class="cp_iptxt">
      <label class="ef">
        <input type="date" name="birth" value="<?php echo $birth; ?>">
      </label>
    </div>

    <div class="cp_iptxt">
      <label class="ef">
        <input type="text" name="mail" placeholder="メールアドレス" value="<?php echo $mail; ?>">
      </label>
    </div>

    <div class="cp_iptxt">
      <label class="ef">
        <input type="password" name="pass1" placeholder="パスワード">
      </label>
    </div>

    <div class="cp_iptxt">
      <label class="ef">
        <input type="password" name="pass2" placeholder="パスワードの再入力">
      </label>
    </div>
    <div style="display:inline-flex;">
      <button type="submit" value="登録" class="button">登録</button>
  </form>

  <div class="btn2"><a href="index.php">戻る</a></div>
  <br>
</div>

</body>
</html>
