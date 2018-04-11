<?php
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/ico" href="../AppMeteo.png"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/stylePhp.css" rel="stylesheet">
</head>

<body>

<nav id="navbar">
    <h2><a href="../index.php">AppMeteo</a></h2>
<ul>
    <?php if(isset($_SESSION['auth'])): ?>
        <li><a href="../php/logout.php">Deconnexion</a></li>
    <?php else: ?>
        <li><a href="../php/login.php">Se Connecter</a></li>
    <?php endif; ?>
</ul>
</nav>
<main role="main" class="container">

    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach ($_SESSION['flash'] as $type => $message): ?>

            <div class="alert alert-<?=$type; ?>">
                <?= $message; ?>
            </div>

        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
