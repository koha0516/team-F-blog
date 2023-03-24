<?php
require_once '../DB/user_dao.php';
$user_id =  $_POST['uid'];
$followed = $_POST['fid'];
create_follow($user_id,$followed);

