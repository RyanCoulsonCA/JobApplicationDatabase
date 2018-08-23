<?php
require_once "connect.php";

$id = mysql_real_escape_string(intval($_POST['id']));
$body = mysql_real_escape_string(strip_tags(stripslashes($_POST['body'])));

mysql_query("UPDATE `application` SET `notes`='$body' WHERE `id`='$id'");
echo "success";
?>