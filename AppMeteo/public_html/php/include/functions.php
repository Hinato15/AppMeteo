<?php

function debug($variable)
{
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function str_random($length)
{
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0,$length);
}

function logged_only()
{

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(!isset($_SESSION['auth']))
    {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        echo '<script>document.location.href="login.php";</script>';
        exit();
    }
}

function logged_only_login()
{
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(isset($_SESSION['auth']))
    {
        $_SESSION['flash']['danger'] = "Vous êtes déjà connecté";
        echo '<script>document.location.href="account.php";</script>';
        exit();
    }
}