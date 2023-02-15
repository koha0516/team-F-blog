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
  <link rel="stylesheet" href="css/style.css">
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

  <div id="login-form">
    <form action="login.php" method="post">
      <input type="text" name="name" placeholder="氏名" value="<?php echo $name; ?>" required><br>
      <input type="password" name="pass" placeholder="パスワード" required><br>

      <a href="../">戻る</a>
      <input type="submit" value="ログイン">
    </form>
  </div>

</body>
</html>
