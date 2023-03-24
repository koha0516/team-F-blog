<?php
session_start();
// htmlプレースホルダのための変数
$name = "";
$mail = "";

if (isset($_SESSION['user_info'])) {
  $user = $_SESSION['user_info'];
  $name = $user['user_name'];
  $mail = $user['user_mail'];
}

//セッションに値が入っていたらセットする
if (isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
}

if (isset($_SESSION['mail'])) {
  $mail = $_SESSION['mail'];
}


//名前入力エラーがあった場合はエラーメッセージを表示する
if (isset($_SESSION['error_name'])) {
  echo "<script>alert('" . $_SESSION['error_name'] . "')</script>";
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

<!--  ヘッダー  -->
<header>
  <a href="../index.php"><h1>ミジンコ</h1></a>
  <nav class="pc-nav">
    <ul>
      <!--  検索窓　-->
      <li>
        <form action="index.php" method="get">
          <div style="display:inline-flex">
            <div class="cp_iptxt">
              <label class="ef">
                <input type="search" name="keyward" placeholder="キーワード">
              </label>
            </div>
          </div>
          <button type="submit" aria-label="検索" class="search_btn">検索</button>
        </form>
      </li>
      <!--  ヘッダーナビ   -->
      <li class="btn"><a href="#">いいね</a></li>
      <li class="btn"><a href="../articles/post-form.php">投稿</a></li>
      <li class="btn"><a href="my-page.php">アカウント</a></li>
      <li class="btn"><a href="../user/logout.php">ログアウト</a></li>
    </ul>
  </nav>
</header>

<!--コンテンツ-->
<div class="box">
  <h2>新規登録</h2>
  <form action="edit-user.php" method="post">

    <div class="cp_iptxt">
      <label class="ef">
        <input type="text" name="name" placeholder="お名前" value="<?php echo $name; ?>">
      </label>
    </div>

    <div class="cp_iptxt">
      <label class="ef">
        <input type="text" name="mail" placeholder="メールアドレス" value="<?php echo $mail; ?>">
      </label>
    </div>

    <div style="display:inline-flex;">
      <button type="submit" value="変更" class="button">変更</button>
  </form>

  <div class="btn2"><a href="index.php">戻る</a></div>
  <br>
</div>

</body>
</html>

