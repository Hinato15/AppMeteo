<?php

session_start();

unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous êtes maintenant déconnecté";

echo '<script>document.location.href="login.php";</script>';

