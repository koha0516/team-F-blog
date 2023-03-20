<?php
require_once '../DB/article_dao.php';
$article_id =  $_POST['aid'];
$user_id = $_POST['uid'];
create_like($article_id,$user_id);


