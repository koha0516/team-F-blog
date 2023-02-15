<?php
  session_start();

  //セッションに値が入っていたら初期値としてセットする
  $name = "";
  if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
  }

  // エラーメッセージ表示
  if (isset($_SESSION['error_name'])) {
    echo "<script>alert('" . $_SESSION['error_name'] . "')</script>";
  }
  if (isset($_SESSION['error_pass'])) {
    echo "<script>alert('" . $_SESSION['error_pass'] . "')</script>";
  }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>login</title>
</head>

<body>
  <header>
    <a href="/"><h1>ミジンコ</h1></a>
    <nav class="pc-nav">
      <ul>
        <li class="btn"><a href="./user/login-form.php">ログイン</a></li>
        <li class="btn"><a href="./user/signUp-form.php">新規登録</a></li>
      </ul>
    </nav>
  </header>

  <!--コンテンツ-->
  <div class="box">
    <h2>ログイン画面</h2>
    <form action="login.php" method="post">

      <div class="cp_iptxt">
        <label class="ef">
          <input type="text" name="name" placeholder="お名前" value="<?php echo $name; ?>" required>
        </label>
      </div>

      <div class="cp_iptxt">
        <label class="ef">
          <input type="password" name="password" placeholder="パスワード" required>
        </label>
      </div>

      <div style="display:inline-flex;">
        <button type="submit" value="ログイン" class="button">ログイン</button>
    </form>

    <div class="btn2"><a href="index.php">戻る</a></div><br>
  </div>

  <div style="margin-top: 10px;">
    <a href="signUp-form.php">新規登録</a>
    <a href="edit-password.php">パスワードを忘れた方はこちら</a>
  </div>

  </div>

</body>
</html>
