<?php
require_once("../db/connection.php");
require_once("../helpers/session.php");
require_once("../helpers/utils.php");
require_once("../helpers/constants.php");

if (!isset($_SESSION['loggedin']) || $_SESSION['user_type'] != BROKER_ROLE) {
    redirect_to($_SERVER['HTTP_REFERER']);
}
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect_to('/');
}

$db = new DB();

$user_id = $_SESSION['user_id'];
$estate_id = intval($_POST['estate_id']);

$record = $db->first("SELECT * FROM real_estates WHERE id=$estate_id and user_id=$user_id");

if ($record === false) {
    redirect_to($_SERVER['HTTP_REFERER']);
}
$db->exec("DELETE FROM real_estates WHERE id=$estate_id");
redirect_to('/my-real-estates.php');
