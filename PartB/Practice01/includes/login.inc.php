<?php

if (isset($_POST['submit']))
{
    $uid = $_POST['uid'];    
    $pwd = $_POST['pwd'];    

    include '../classes/dbh.classes.php';
    include '../classes/login.classes.php';
    include '../classes/login-contr.classes.php';
    $signup = new LoginContr($uid, $pwd);

    $signup->loginUser();

    header("location: ../index.php?error=none");
}