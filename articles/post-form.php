<?php
session_start();

// プレースホルダの変数
$title = "";
$contents = "";
$tag = [
    "1"=>"",
    "2"=>"",
    "3"=>"",
    "4"=>"",
    "5"=>"",
    "6"=>"",
    "7"=>"",
    "8"=>"",
    "9"=>"",
    "10"=>"",
    "11"=>"",
];
$publish = "";

//セッションに値が入っていたらセットする
if (isset($_SESSION['title'])) {
   $title = $_SESSION['title'];
}
if (isset($_SESSION['contents'])) {
   $contents = $_SESSION['bcontentsirth'];
}
if (isset($_SESSION['tag'])) {
   $tag = $_SESSION['tag'];
}
if (isset($_SESSION['publish'])) {
    $publish = $_SESSION['publish'];
}
$user=[];
var_dump($_SESSION['user_info']);
if (isset($_SESSION['user_info'])){
    $user = $_SESSION['user_info']; 
    $userid=$user['user_id'];
}

var_dump($userid);

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
<form action="post.php" method="post">
    <input type="text" name="title" placeholder="タイトル" value="<?php echo $title; ?>"><br>
    <textarea name="contents" placeholder="内容を入力してください" value="<?php echo $contents; ?>"></textarea><br>
    <select name="tag">
        <option value="1" <?php echo $tag['1'];?>>ファッション</option>
        <option value="2" <?php echo $tag['2'];?>>ペット</option>
        <option value="3" <?php echo $tag['3'];?>>料理</option>
        <option value="4" <?php echo $tag['4'];?>>美容</option>
        <option value="5" <?php echo $tag['5'];?>>旅行</option>
        <option value="6" <?php echo $tag['6'];?>>グルメ</option>
        <option value="7" <?php echo $tag['7'];?>>インテリア&DIY</option>
        <option value="8" <?php echo $tag['8'];?>>コラム</option>
        <option value="9" <?php echo $tag['9'];?>>海外生活</option>
        <option value="10"<?php echo $tag['10'];?>>専門家</option>
        <option value="11"<?php echo $tag['11'];?>>趣味</option>
    </select>
    <input type="radio" name="publish" value="公開">公開
    <input type="radio" name="publish" value="非公開">非公開<br>
    <input type="submit"value="投稿">
    <a href="../">戻る</a>
</form>
    
</body>
</html>