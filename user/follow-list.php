<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/user_dao.php';
require_once '../DB/article_dao.php';

//dbからデータを取得(タグ)
$tags = get_tags();

if ($_SESSION['user_info'] !== null) {
//  ログイン情報取得
  $user = $_SESSION['user_info'];
  $follows = get_follows($user['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/follow_style.css">
  <title>ミジンコ|フォローリスト</title>
</head>

<body>
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
          <li><a href="index.php">すべて</a></li>
          <?php
          foreach ($tags as $t){
          ?>
          <li><a href="../index.php?tag_id=<?php echo $t['tag_id']?>"><?php echo $t['tag_name']?></a></li>
          <?php } ?>
        </ol>
      </div>

      <div class="content">
        <h2>フォローリスト</h2>
        <?php if(empty($follows)){ ?>
          <h3>フォローしていません</h3>
        <?php } else {
          foreach ($follows as $f) {?>
        <table>
          <tr>
            <th><?php echo get_user_name($f['followed_user_id']);?></th>
            <td>フォロー中</td>
          </tr>
        </table>
          <?php } ?>
        <?php } ?>


      </div>

    </article>
  </div>
</div>
</body>
</html>