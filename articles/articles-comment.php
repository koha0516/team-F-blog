<?php
session_start();

$comment = json_encode($_POST['comment'],JSON_UNESCAPED_UNICODE);

if (isset($_SESSION['user_info'])) {
    $user = $_SESSION['user_info'];
    $name = ($user['user_name']);
    $res = ["name" => $name, "comment" => $comment];
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($res);
};

exit;