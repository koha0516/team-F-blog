<?php
//セッションを利用するためのメソッド
session_start();

//DBに接続
require_once '../DB/user_dao.php';
require_once '../DB/article_dao.php';

//dbからデータを取得(記事とタグ)
$article = get_article($_GET['article_id']);
$tags = get_tags();

if (!empty($_SESSION['user_info'])) {
//  ログイン情報取得
  $user = $_SESSION['user_info'];
//　いいね情報取得
  $like = check_like($_GET['article_id'], $user['user_id']);
//  フォロー情報取得
  $follow = check_follow($user['user_id'], $article['user_id']);
}

//dbからコメントを取得
$comments = [];
$comments = get_comments($_GET['article_id']);

// 記事のインデックス番号取得
$articles = $_SESSION['articles'];
$id_array = array_column($articles, 'article_id');
$article_index = array_keys($id_array, $_GET['article_id'])[0];

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/browse_style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <title>ミジンコ</title>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
</head>

<body>
<!--ヘッダー　（ログイン後とログイン前で場合分け）-->
<?php if (empty($_SESSION['user_info'])) { ?>
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
          foreach ($tags as $t) {
            ?>

            <li><a href="../index.php?tag_id=<?php echo $t['tag_id'] ?>"><?php echo $t['tag_name'] ?></a></li>
          <?php } ?>
        </ol>
      </div>

      <!--   記事　　-->
      <?php if ($article['published'] > 0) { ?>
        <div class="content">
          <div class="box">
            <h2><?php echo $article['title'] ?></h2>
            <?php echo get_user_name($article['user_id']) ?>　<?php echo $article['update_at'] ?>
            <hr>
            <p><?php echo $article['article_content'] ?></p>
            <hr>
            <?php echo get_tag_name($article['tag_id']) ?>
          </div>
        </div>
      <?php } else { ?>
        <div class="content2">
          <div class="box">
            <h2>この記事は非公開or削除された可能性があります</h2>
          </div>
        </div>
      <?php } ?>

      <!--  コメント  -->
      <div class="comment">
        <!--  コメント欄  -->
        <div class="box2">
          <div class="co">
            <table id="return">
            <?php
            foreach(array_reverse($comments) as $data){
            ?> 
            <tr>
              <td>
                <p><?php echo $data['user_name']; ?></p>
                <p><?php echo $data['comment_content']; ?></p>
              </td>
            </tr>
            <?php
            }
            ?>
            </table>
          </div>
        </div>
        　　　　　<!--  コメント入力フォーム　　-->
          <div style="display:inline-flex">
            <div class="cp_iptxt">
              <label class="ef">
                <input type="text" name="comment" placeholder="コメント" id="comment">
              </label>
            </div>
              <button type="submit" aria-label="送信" class="comment_btn" id="send">送信</button>
          </div>

        <script>
          //ajax//
        $(function(){
          $("#send").on("click", function(event){//ボタンが押された時に動作
            let comment = $("#comment").val();
            console.log(comment);
            console.log(window.location.search);
            const searchParams = new URLSearchParams(window.location.search);
            let article_id = searchParams.get('article_id');
            $.ajax({
              type: "POST",
              url: "articles-comment.php",
              dataType: "json",
              data: {comment:comment,name:name,article_id:article_id}
            }).done(function(data){
              console.log(data.comment);
              console.log('成功しました');
              /* 
              <tr>
              <td>
                <p><?php echo $data['user_name']; ?></p>
                <p><?php echo $data['comment_content']; ?></p>
              </td>
              </tr>
              */
              $("#return").prepend('<tr><td><p>'+data.name+'</p><p>'+data.comment+'</p></td></tr>');
            }).fail(function(XMLHttpRequest, status, e){
              console.log(e);
              console.log('失敗しました');
            });
          });
        });
        </script>

        <!--    いいねボタンとフォローボタン    -->
        <div style="display:inline-flex">
          <?php if (empty($like)) {
            $li = 0;
          } else {
            $li = 1;
          } ?>
          <?php if (empty($follow)) {
            $fo = 0;
          } else {
            $fo= 1;
          } ?>

          <!--いいねしていないとき-->
          <button type="button" class="like_btn" id="like_btn" data-like="<?php echo $li; ?>" data-user="<?php echo $user['user_id']; ?>"
                  data-article="<?php echo $article['article_id']; ?>">いいね
          </button>

          <!--フォローしていないとき-->
          <button type="button" class="follow_btn" id="follow_btn" data-fo="<?php echo $fo; ?>" data-follow="<?php echo $article['user_id']; ?>"
                  data-user="<?php echo $user['user_id']; ?>">フォロー
          </button>

          <!--    フォロー中    -->
<!--            <span class="swtext">-->
<!--              <span>-->
<!--                <button type="button" class="follow2_btn">フォロー中</button>-->
<!--              </span>-->
<!---->
<!--              <span>-->
<!--                <button type="button" class="follow2_btn">フォローを外す</button>-->
<!--              </span>-->
<!--            </span>-->
        </div>
      </div>
    </article>
  </div>
</div>
<?php
//  次のページ前のページ
if (isset($articles[$article_index + 1])) {
  $next_page = $articles[$article_index + 1]['article_id'];
} else {
  $next_page = $articles[0]['article_id'];
}

if (isset($articles[$article_index - 1])) {
  $pre_page = $articles[$article_index - 1]['article_id'];
} else {
  $pre_page = $articles[count($id_array) - 1]['article_id'];
}
?>
<div class="lower_contents">
  <ul>
    <li class="btn2"><a href="./browse-article.php?article_id=<?php echo $pre_page; ?>">←</a></li>
    <li class="btn2"><a href="../">戻る</a></li>
    <li class="btn2"><a href="./browse-article.php?article_id=<?php echo $next_page; ?>">→</a></li>
  </ul>
</div>

<script>
  $(function () {
    let like_btn = $('#like_btn');
    let li = document.getElementById('like_btn').dataset.like;
    let follow_btn = $('#follow_btn');
    let fo = document.getElementById('follow_btn').dataset.fo;

    toggle_like(li);
    toggle_follow(fo);

    function toggle_like(li) {
      if (li == 0) {
        like_btn.removeClass('like2_btn');
        like_btn.addClass('like_btn');
      } else {
        like_btn.removeClass('like_btn');
        like_btn.addClass('like2_btn');
      }
    }
    function toggle_follow(fo) {
      if (fo == 0) {
        follow_btn.removeClass('follow2_btn');
        follow_btn.addClass('follow_btn');
      } else {
        follow_btn.removeClass('follow_btn');
        follow_btn.addClass('follow2_btn');
      }
    }

    // いいね機能
    like_btn.on('click', function () {
      let article_id = document.getElementById('like_btn').dataset.article;
      let user_id = document.getElementById('like_btn').dataset.user;
      if(li == 0){
        // いいねする
        $.ajax({
          url: 'like.php',
          type: 'POST',
          data: {aid: article_id, uid: user_id},
        }).then(
          // 1つめは通信成功時のコールバック
          function (data) {
            console.log(data);
          },
          // 2つめは通信失敗時のコールバック
          function () {
            alert("読み込み失敗");
          }
        );
        li = 1;
      } else {
        // いいねを外す
        $.ajax({
          url: 'dislike.php',
          type: 'POST',
          data: {aid: article_id, uid: user_id},
        }).then(
          // 1つめは通信成功時のコールバック
          function (data) {
            console.log(data);
          },
          // 2つめは通信失敗時のコールバック
          function () {
            alert("読み込み失敗");
          }
        );
        li = 0;
      }
      toggle_like(li);
    })

    // フォロー機能
    follow_btn.on('click', function () {
      let follow = document.getElementById('follow_btn').dataset.follow;
      let user_id = document.getElementById('follow_btn').dataset.user;
      if(fo == 0){
        // フォローする
        $.ajax({
          url: '../user/follow.php',
          type: 'POST',
          data: {fid: follow, uid: user_id},
        }).then(
          // 1つめは通信成功時のコールバック
          function (data) {
            console.log(data);
          },
          // 2つめは通信失敗時のコールバック
          function () {
            alert("読み込み失敗");
          }
        );
        fo = 1;
      } else {
        // フォローを外す
        $.ajax({
          url: '../user/delete-follow.php',
          type: 'POST',
          data: {fid: follow, uid: user_id},
        }).then(
          // 1つめは通信成功時のコールバック
          function (data) {
            console.log(data);
          },
          // 2つめは通信失敗時のコールバック
          function () {
            alert("読み込み失敗");
          }
        );
        fo = 0;
      }
      toggle_follow(fo);
    })
  })
</script>
</body>
</html>