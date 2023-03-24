<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/user_dao.php';
require_once '../DB/article_dao.php';

//dbからデータを取得(記事とタグ)
$tags = get_tags();

// 初期値設定用に変数を定義
$title = "";
$contents = "";
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
$publish = "";

//セッションに値が入っていたら初期値としてセットする
if (isset($_SESSION['title'])) {
  $title = $_SESSION['title'];
}
if (isset($_SESSION['contents'])) {
  $contents = $_SESSION['contents'];
}
for ($i = 1; $i < 12; $i++) {
  if (isset($_SESSION['tag'])) {
    if ($_SESSION['tag'] == $i) {
      $tag["$i"] = "selected";
    }
  }
}
if (isset($_SESSION['publish'])) {
  $publish = $_SESSION['publish'];
}


//セッション（ログイン情報）からユーザIDを取り出す
if (isset($_SESSION['user_info'])) {
  $user = $_SESSION['user_info'];
  $userid = $user['user_id'];
}


//入力エラーがあった場合にエラーメッセージを表示(これはアラートが表示されるJS)
if (isset($_SESSION['error_title'])) {
  echo "<script>alert('" . $_SESSION['error_title'] . "')</script>";
}
if (isset($_SESSION['error_contents'])) {
  echo "<script>alert('" . $_SESSION['error_contents'] . "')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/register_style.css">

  <title>ミジンコ|投稿ページ</title>
</head>

<body>
<header>
  <a href="../index.php"><h1>ミジンコ</h1></a>
  <nav class="pc-nav">
    <ul>
      <!--  検索窓　-->
      <li>
        <form action="../index.php" method="get">
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
      <li class="btn"><a href="../articles/like-list.php">いいね</a></li>
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

      <!--  サイドバー  -->
      <div class="side">
        <h3>カテゴリー</h3>
        <ol class="sample1">
          <li><a href="../index.php">すべて</a></li>
          <?php
          foreach ($tags as $t){
          ?>
          <li><a href="../index.php?tag_id=<?php echo $t['tag_id']?>"><?php echo $t['tag_name']?></a></li>
          <?php } ?>
        </ol>
      </div>

      <!--   投稿フォーム   -->
      <div class="content">
        <h3>投稿ページ</h3>
        <form action="post.php" method="post">
          <div class="cp_iptxt">
            <label class="ef">
              <input type="text" name="title" placeholder="タイトル" value="<?php echo $title; ?>"><br>
            </label>
          </div>
          <div class="wordcounter">
            <textarea name="contents" id="article" placeholder="内容を入力してください" value="<?php echo $contents; ?>"></textarea>
            <div class="wordcount">
              残り<div class="length">10000</div>文字
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
            <input type="checkbox" id="switch1" name="publish" value="1">
            <label for="switch1"><span></span></label>
            <div id="swImg"></div>
          </div>
          <div style="display:inline-flex;">
            <button type="submit" id="submit" value="投稿" class="button" disabled>投稿</button>
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