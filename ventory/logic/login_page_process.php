<?php

require_once "../util/dbhelper.php";

$db = new DbHelper();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = htmlspecialchars($username);
    $admin_login = $db->getRecord('admin', ['username' => $username]);
    if ($admin_login && password_verify($password, $admin_login['password'])) {
        header('Location: ../index.php');
        exit();
    } else {
        // Handle failed login
        header('Location: ../login.php?m=INVALID+USERNAME+OR+PASSWORD');
        exit();
    }
}
