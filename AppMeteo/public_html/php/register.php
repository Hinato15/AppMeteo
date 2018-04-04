<?php require 'include/functions.php' ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Inscription</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/ico" href="../AppMeteo.png"/>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/stylePhp.css" rel="stylesheet">
    </head>

<body>

<nav id="navbar">
    <h2><a href="../index.html">AppMeteo</a></h2>
</nav>
<main role="main" class="container">

    <?php

    if (!empty($_POST)) {
        $errors = array();
        require_once 'include/db.php';


        /* Username */

        if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
            $errors['username'] = "Votre pseudo n'est pas valide";
        } else {
            $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $req->execute([htmlspecialchars($_POST['username'])]);
            $user = $req->fetch();
            if ($user) {
                $errors['username'] = 'Ce pseudo existe déja';
            }
        }

        /* Email */

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Votre email n'est pas valide";
        } else {
            $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $req->execute([htmlspecialchars($_POST['email'])]);
            $user = $req->fetch();
            if ($user) {
                $errors['email'] = 'Cette email existe déja';
            }
        }

        /* Password */

        if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
            $errors['password'] = "Le mot de passe saisi dans le champ de confirmation ne correspond pas";
        }

        if (empty($errors)) {
            $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?");
            $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
            $req->execute([htmlspecialchars($_POST['username']), $password, htmlspecialchars($_POST['email'])]);
            die('Votre compte a bien été créé');
        }

        // debug($errors);
    }

    ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas rempli le formulaire correctement</p>
            <?php foreach ($errors as $error): ?>
                <ul>
                    <li><?= $error; ?></li>
                </ul>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <form action="" method="POST">
        <div form="form-group">
            <label for="">Pseudo</label>
            <input type="text" name="username" class="form-control" required/>
        </div>

        <div form="form-group">
            <label for="">Email</label>
            <input type="text" name="email" class="form-control" required/>
        </div>

        <div form="form-group">
            <label for="">Mot de Passe</label>
            <input type="password" name="password" class="form-control" required/>
        </div>

        <div form="form-group">
            <label for="">Confirmez votre mot de passe</label>
            <input type="password" name="password_confirm" class="form-control" required/>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">M'inscrire</button>
    </form>


</main><!-- /.container -->

<script src="../js/underApp.js"></script>

</body>
</html>

