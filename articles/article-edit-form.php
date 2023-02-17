<?php
session_start();
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';

//記事のIDを取得
if (isset($_GET['article_id'])) {
  $_SESSION['article_id'] = $_GET['article_id'];
}

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

//IDをもとに記事の情報を取得
$article = get_article($_SESSION['article_id']);

//取り出した情報をもとにタグにチェックを入れる
for ($i = 1; $i < 12; $i++) {
  if ($article['tag_id'] == $i) {
    $tag["$i"] = "selected";
  }
}

//取り出した情報をもとに公開フラグを選択する
$p1 = "";
$p2 = "";
if ($article['published'] == 1) {
  $p1 = "checked";
}else{
  $p2 = "checked";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<header>
    <a href="/"><h1>ミジンコ</h1></a>
    <nav class="pc-nav">
        <ul>
            <li class="btn"><a href="login.html">ログイン</a></li>
            <li class="btn"><a href="registeraccount.html">新規登録</a></li>
        </ul>
    </nav>
</header>

<form action="user-edit.php" method="post">
  <input type="text" name="title" placeholder="タイトル" value="<?php echo $article['title']; ?>"><br>
  <textarea name="contents" placeholder="内容を入力してください"><?php echo $article['article_content']; ?></textarea>
  <div class="wordcount">
    <div>残り</div>
    <div class="length">10000</div>
    文字
  </div>
  <select name="tag">
    <?php for ($i = 1; $i < 12; $i++) { ?>
      <option value="<?php echo $i; ?>" <?php echo $tag[$i]; ?>><?php echo get_tag_name($i); ?></option>
    <?php } ?>
  </select><br>
  <input type="radio" name="publish" value="1" <?php echo $p1; ?>>公開
  <input type="radio" name="publish" value="0" <?php echo $p2; ?>>非公開<br>
    <input type="submit"value="更新">
    <a href="../">戻る</a>
</form>
    
</body>
</html>