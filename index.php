<?php
session_start();
require_once './DB/user_dao.php';
require_once './DB/article_dao.php';

//sql実行
$articles = get_articles();
var_dump($_SESSION['user_info']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>ミジンコ</title>
</head>
<body>
<!--ヘッダー-->
<header>
  <a href="/"><h1>ミジンコ</h1></a>
  <nav class="pc-nav">
    <ul>
      <li class="btn"><a href="login.html">ログイン</a></li>
      <li class="btn"><a href="registeraccount.html">新規登録</a></li>
    </ul>
  </nav>
</header>
<!--コンテンツ-->
<div class="wrapper">
  <div class="container">
    <article>
      <div class="side">
        <h3>カテゴリー</h3>
        <ol class="sample1">
          <li><a href="">ファッション</a></li>
          <li><a href="">ペット</a></li>
          <li><a href="">料理</a></li>
          <li><a href="">美容</a></li>
          <li><a href="">旅行</a></li>
          <li><a href="">グルメ</a></li>
          <li><a href="">インテリア＆DIY</a></li>
          <li><a href="">コラム</a></li>
          <li><a href="">海外生活</a></li>
          <li><a href="">専門家</a></li>
          <li><a href="">趣味</a></li>
        </ol>
      </div>

      <div class="content">
        <a href="browse.html">
          <table border="1">
            <?php
              foreach ($articles as $data) {
            ?>
              <tr>
                <td><?php $data['title'] ?></td>
                <td style="text-align: right">いいね</td>
              </tr>
              <tr>
                <td colspan="2"><?php $data['article_content'] ?></td>
              </tr>
              <tr>
                <td><?php $data['update_at'] ?></td>
                <td><?php $data['user_id'] ?></td>
              </tr>
            <?php
              }
            ?>

          </table>
        </a>
      </div>
    </article>
    <br>
  </div>
</div>
</body>
</html>
