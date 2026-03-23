<?php
// logout.php — Destroy session and redirect
require_once 'auth.php';

session_destroy();
header('Location: home.php');
exit;
