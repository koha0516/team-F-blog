<?php
session_start();

//DBに接続
require_once '../DB/get_connect.php';
require_once '../DB/article_dao.php';
require_once '../function/user_function.php';

if(isset($_POST['comment'])){
    $comment =htmlspecialchars($_POST['comment'],ENT_QUOTES,"UTF-8");
}

if (isset($_SESSION['user_info'])) {
    $user = $_SESSION['user_info'];
    $name = ($user['user_name']);
    $comment_user_id = ($user['user_id']);
    $res = ["name" => $name, "comment" => $comment];
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($res);
};
if (isset($_POST['article_id'])){
    $article_id=$_POST['article_id'];
};
register_comments($article_id, $comment_user_id, $comment);

exit;