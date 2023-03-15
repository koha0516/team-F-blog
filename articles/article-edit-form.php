<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';


//getで記事のIDを取得
if (isset($_GET['article_id'])) {
  $_SESSION['article_id'] = $_GET['article_id'];
}


//IDをもとに記事の情報を取得
$article = get_article($_SESSION['article_id']);

//取り出した情報をもとにタグにチェックを入れる
$tag = [
  "1" => "",
  "2" => "",
  "3" => "",
  "4" => "",
  "5" => "",
  "6" => "",
  "7" => "",
  "8" => "",
  "9" => "",
  "10" => "",
  "11" => "",
];
for ($i = 1; $i < 12; $i++) {
  if ($article['tag_id'] == $i) {
    $tag["$i"] = "selected";
  }
}

//取り出した情報をもとに公開フラグを選択する
$published = "";
if ($article['published'] == 1) {
  $published = "checked";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register_style.css">


  <title>編集ページ</title>
</head>

<body>
<header>
  <a href="../"><h1>ミジンコ</h1></a>
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
          <a href="../">戻る</a>
        </form>
      </li>
      <!--  ヘッダーナビ   -->
      <li class="btn"><a href="#">いいね</a></li>
      <li class="btn"><a href="../articles/post-form.php">投稿</a></li>
      <li class="btn"><a href="../user/my-page.php">アカウント</a></li>
      <li class="btn"><a href="../user/logout.php">ログアウト</a></li>
    </ul>
  </nav>
</header>

<!--コンテンツ-->
<div class="wrapper">
  <div class="container">
    <article>
      <!--   編集フォーム   -->
      <div class="content">
        <h3>編集ページ</h3>
        <form action="article-edit.php" method="post">
          <div class="cp_iptxt">
            <label class="ef">
              <input type="text" name="title" placeholder="タイトル" value="<?php echo $article['title']; ?>"><br>
            </label>
          </div>
          <div class="wordcounter">
            <textarea name="contents" id="article" placeholder="内容を入力してください"><?php echo $article['article_content']; ?></textarea>
            <div class="wordcount">
              残り<div class="length"><?php echo 10000-mb_strlen($article['article_content']) ?></div>文字
            </div>
          </div>

          <div class="cp_ipselect cp_sl01">
            <select name="tag" id="sources" required placeholder="カテゴリー">
              <?php for ($i = 1; $i < 12; $i++) { ?>
                <option value="<?php echo $i; ?>" <?php echo $tag[$i]; ?>><?php echo get_tag_name($i); ?></option>
              <?php } ?>
            </select><br>
          </div>
          <!-- 公開非公開(トグルボタン) -->
          <div class="switchArea">
            <input type="checkbox" id="switch1" name="publish" value="1" <?php echo $published; ?>>
            <label for="switch1"><span></span></label>
            <div id="swImg"></div>
          </div>

          <div style="display:inline-flex;">
            <button type="submit" id="submit" value="投稿" class="button" disabled>更新</button>
            <div class="btn2"><a href="../index.php">戻る</a></div><br>
          </div>
        </form>

      </div>
    </article>
  </div>
</div>

<script src="../js/main.js"></script>
</body>
</html>