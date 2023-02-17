<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once './DB/user_dao.php';
require_once './DB/article_dao.php';

//dbからデータを取得(記事とタグ)
$articles =[];
if(!empty($_GET['tag_id'])) {
  $articles = get_tag_articles($_GET['tag_id']);
}else{
  $articles = get_articles();
}
$tags = get_tags();
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
<!--ヘッダー　（ログイン後とログイン前で場合分け）-->
<?php if(empty($_SESSION['user_info'])){ ?>
<header>
  <a href="/"><h1>ミジンコ</h1></a>
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
      <li class="btn"><a href="./user/login-form.php">ログイン</a></li>
      <li class="btn"><a href="./user/signUp-form.php">新規登録</a></li>
    </ul>
  </nav>
</header>
<?php }else { ?>
<header>
  <a href="index.php"><h1>ミジンコ</h1></a>
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
      <li class="btn"><a href="./articles/post-form.php">投稿</a></li>
      <li class="btn"><a href="./user/mypage.php">アカウント</a></li>
      <li class="btn"><a href="./user/logout.php">ログアウト</a></li>
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
          <li><a href="index.php">すべて</a></li>
          <?php
          foreach ($tags as $t){
          ?>
          <li><a href="index.php?tag_id=<?php echo $t['tag_id']?>"><?php echo $t['tag_name']?></a></li>
          <?php } ?>
        </ol>
      </div>

      <!--   記事一覧  (新しい順) -->
      <div class="content">
        <?php
        foreach (array_reverse($articles) as $data) {
        ?>
          <table>
            <tr>
              <td><a href="./articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo $data['title']; ?></a></td>
              <td style="text-align: right">いいねボタン</td>
            </tr>
            <tr>
              <td colspan="2"><a href="./articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo $data['article_content'] ?></a></td>
            </tr>
            <tr>
              <td><a href="./articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo $data['update_at'] ?></a></td>
              <td><a href="./articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo get_user_name($data['user_id']) ?></a></td>
            </tr>
          </table>

          <br>
        <?php
        }
        ?>
      </div>

    </article>
  </div>
</div>
</body>
</html>
