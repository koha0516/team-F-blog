<?php
session_start();
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';

//記事のIDを取得
if (isset($_GET['articleid'])) {
  $_SESSION['articleid'] = $_GET['articleid'];
}

//IDをもとに記事の情報を取得
$article = get_article($_SESSION['articleid']);

//入力エラーがあった場合にエラーメッセージを表示
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
<?php echo $article['article_content'] ?>
<form action="user-edit.php" method="post">
    <input type="text" name="title" placeholder="タイトル" value="<?php echo $article['title'] ?>"><br>
    <textarea name="contents" placeholder="内容を入力してください"><?php echo $article['article_content'] ?></textarea><br>
    <select name="tag">
        <option value="1">ファッション</option>
        <option value="2">ペット</option>
        <option value="3">料理</option>
        <option value="4">美容</option>
        <option value="5">旅行</option>
        <option value="6">グルメ</option>
        <option value="7">インテリア&DIY</option>
        <option value="8">コラム</option>
        <option value="9">海外生活</option>
        <option value="10">専門家</option>
        <option value="11">趣味</option>
    </select>
    <input type="radio" name="publish" value="公開">公開
    <input type="radio" name="publish" value="非公開">非公開<br>
    <input type="submit"value="更新">
    <a href="../">戻る</a>
</form>
    
</body>
</html>