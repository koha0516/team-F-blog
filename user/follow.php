<?php
require_once '../DB/article_dao.php';
$user_id =  $_POST['uid'];
$followed = $_POST['fid'];
create_like($user_id,$followed);