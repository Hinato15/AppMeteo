<?php

$users_id = $_GET['id'];
$token = $_GET['token'];

require 'include/db.php';

$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$users_id]);
$user = $req->fetch();
session_start();

if($user && $user->confirmation_token == $token)
{
    session_start();
    $req = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$users_id]);
    $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
    $_SESSION['auth'] = $user;
    echo '<script>document.location.href="account.php";</script>';

} else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    echo '<script>document.location.href="login.php";</script>';
}