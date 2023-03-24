<?php
// セッションを利用するためのメソッド
session_start();

// DB操作用ファイルを読み込む
require_once '../DB/user_dao.php';
require_once '../DB/article_dao.php';

//  ログイン情報取得
$user = $_SESSION['user_info'];

// DBから記事を取得
//$articles =[];
$likes = get_likes($user['user_id']);
//$_SESSION['articles'] = $articles;


//  DBからサイドバーに表示するタグ名を取得
$tags = get_tags();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/like_style.css">
  <title>ミジンコ|トップページ</title>
</head>

<body>
<!--ヘッダー　（ログイン後とログイン前で場合分け）-->
<?php if(empty($_SESSION['user_info'])){ ?>
  <header>
    <a href="index.php"><h1>ミジンコ</h1></a>
    <nav class="pc-nav">
      <ul>
        <!--  検索窓　-->
        <li>
          <form action="../index.php" method="get">
            <div style="display:inline-flex">
              <div class="cp_iptxt">
                <label class="ef">
                  <input type="search" name="keyword" placeholder="キーワード">
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
<?php }else { ?>
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
          foreach ($tags as $t){
            ?>
            <li><a href="../index.php?tag_id=<?php echo $t['tag_id']?>"><?php echo $t['tag_name']?></a></li>
          <?php } ?>
        </ol>
      </div>

      <!--   記事一覧  (新しい順) -->
      <div class="content">
        <h2>いいねした記事</h2>
        <?php
        if(!empty($likes)){
          foreach (array_reverse($likes) as $li) {
            $article = get_article($li['article_id']);
            ?>
            <a href="../articles/browse-article.php?article_id=<?php echo $article['article_id']; ?>">
              <table>
                <tr>
                  <th><?php echo $article['title']; ?></th>
                  <!--    いいねボタン    -->
                  <td style="text-align: right; z-index: 10000; position: relative;">
                    <button type="button" class="like_btn" id="like_btn"
                            data-like="<?php echo $li; ?>" data-user="<?php echo $user['user_id']; ?>"
                            data-article="<?php echo $article['article_id']; ?>">いいね
                    </button>
                  </td>
                </tr>
                <tr>
                  <th colspan="2"><?php echo $article['article_content'] ?></th>
                </tr>
                <tr>
                  <th><?php echo $article['update_at'] ?></th>
                  <td><?php echo get_user_name($article['user_id']) ?></td>
                </tr>
              </table>
            </a>
            <?php
          }
        }else{
          echo "<h2>いいねした記事はありません</h2>";
        }
        ?>
      </div>

    </article>
  </div>
</div>

</body>
</html>
