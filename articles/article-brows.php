<?php
session_start();
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';

if (isset($_GET['articleid'])) {
  $_SESSION['articleid'] = $_GET['articleid'];
}
  
//IDをもとに記事の情報を取得
$article = get_article($_SESSION['articleid']);
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
    <?php echo $article['title'] ?>
    <?php echo $article['article_content'] ?>
    <?php echo $article['tag_id'] ?>
    <?php echo $article['user_id'] ?>
    <?php echo $article['create_at'] ?>
    <?php echo $article['update_at'] ?>
</body>
</html>