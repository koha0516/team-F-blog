<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/user_dao.php';
require_once '../DB/article_dao.php';

//セッションからユーザIDを取り出す
if (isset($_SESSION['user_info'])) {
  $user = $_SESSION['user_info'];
  $user_id = $user['user_id'];
}

//dbからデータを取得(記事とタグ)
$articles = get_own_articles($user_id);
$_SESSION['articles'] = $articles;

$follower = get_followers($user_id);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/my-page.css">
  <title>ミジンコ|マイページ</title>
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
<div class="upper_content">

  <div class="left">
    <?php
    echo $user['user_name'];
    ?>
    <a href="./edit-user-info.php"><img src="../img/edit.png" class="edit-icon"></a>
    <br>
    <div class="left_under">
      <div class="left2">
        フォロワー：<?php echo count($follower) ?>人
      </div>
      <div class="right2">
        投稿：<?php echo count($articles) ?>件
      </div>
      <div class="left2">
        <a href="./follow-list.php">フォローリスト</a>
      </div>
    </div>
  </div>

  <div class="right2">
    <div class="btn3"><a href="edit-password.php">パスワード変更</a></div>
  </div>

</div>

  <!--   記事一覧  (新しい順) -->
<div class="content">
  <?php
  foreach (array_reverse($articles) as $data) {
  ?>
    <table>
      <tr>
        <td>
          <a href="../articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo $data['title']; ?></a>
        </td>
        <td style="text-align: right">
        <div class="edit_btn">
          <a href="../articles/article-edit-form.php?article_id=<?php echo $data['article_id'] ?>">編集</a>
        </div>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <a href="../articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo $data['article_content'] ?></a>
        </td>
      </tr>
      <tr>
        <td>
          <a href="../articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo $data['update_at'] ?></a>
        </td>
        <td>
          <a href="../articles/browse-article.php?article_id=<?php echo $data['article_id'] ?>"><?php echo get_user_name($data['user_id']) ?></a>
        </td>
      </tr>
    </table>
    <br>
  <?php
  }
  ?>
</div>

</body>
</html>
