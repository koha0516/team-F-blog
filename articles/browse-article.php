<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/user_dao.php';
require_once '../DB/article_dao.php';

//dbからデータを取得(記事とタグ)
$article = get_article($_GET['article_id']);
$tags = get_tags();
if($_SESSION['user_info'] !== null){
  $user = $_SESSION['user_info'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/browse_style.css">
  <title>ミジンコ</title>
</head>

<body>
<!--ヘッダー　（ログイン後とログイン前で場合分け）-->
<?php if (empty($_SESSION['user_info'])) { ?>
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
        <li class="btn"><a href="../user/login-form.php">ログイン</a></li>
        <li class="btn"><a href="../user/signUp-form.php">新規登録</a></li>
      </ul>
    </nav>
  </header>
<?php } else { ?>
  <header>
    <a href="/"><h1>ミジンコ</h1></a>
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
        <li class="btn"><a href="#">いいね</a></li>
        <li class="btn"><a href="../articles/post-form.php">投稿</a></li>
        <li class="btn"><a href="../user/my-page.php">アカウント</a></li>
        <li class="btn"><a href="../user/logout.php">ログアウト</a></li>
      </ul>
    </nav>
  </header>
<?php } ?>

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
          foreach ($tags as $t) {
            ?>
            <li><a href="../index.php?tag_id=<?php echo $t['tag_id'] ?>"><?php echo $t['tag_name'] ?></a></li>
          <?php } ?>
        </ol>
      </div>

      <!--   記事　　-->
      <?php if($article['published'] > 0){ ?>
      <div class="content">
        <div class="box">
          <h2><?php echo $article['title'] ?></h2>
          <?php echo get_user_name($article['user_id']) ?>　<?php echo $article['update_at'] ?>
          <hr>
          <p><?php echo $article['article_content'] ?></p>
          <hr>
          <?php echo get_tag_name($article['tag_id']) ?>
        </div>
        <div class="btn2"><a href="../">戻る</a></div>
        <br>
      </div>
      <?php } ?>

      <!--  コメント  -->
      <div class="comment">
        <!--  コメント欄  -->
        <div class="box2">
          <div class="co">
            コメント
          </div>
        </div>

　　　　　<!--  コメント入力フォーム　　-->
        <form>
          <div style="display:inline-flex">
            <div class="cp_iptxt">
              <label class="ef">
                <input type="text" name="comment" placeholder="コメント">
              </label>
            </div>
            <button type="submit" aria-label="送信" class="comment_btn">送信</button>
          </div>
        </form>

        <div class="like">like</div> <!--勝手に追加-->
        <div id="text-button" onclick="clickDisplayAlert()">Click</div>

        <script>
          function clickDisplayAlert() {
            alert("ボタンがクリックされました！");
            <?php create_follow($user['user_id'], $article['user_id']) ?>
          }
        </script>

      </div>
    </article>
  </div>
</div>
</body>
</html>