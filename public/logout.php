<?php
require_once('../helpers/session.php');
require_once('../helpers/utils.php');
$_SESSION = [];
session_destroy();

redirect_to('/');
