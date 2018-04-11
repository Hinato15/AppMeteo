<?php require_once 'include/functions.php' ?>
<?php session_start(); ?>
<?php
$title = "Inscription";
?>
<?php require 'include/header.php' ?>
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
                $errors['username'] = 'Ce pseudo existe déjà';
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
                $errors['email'] = 'Cet email existe déjà';
            }
        }

        /* Password */

        if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
            $errors['password'] = "Le mot de passe saisi dans le champ de confirmation ne correspond pas";
        }

        if (empty($errors)) {
            $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
            $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
            $token = str_random(20);
            $req->execute([htmlspecialchars($_POST['username']), $password, htmlspecialchars($_POST['email']), $token]);
            $user_id = $pdo->lastInsertId();
            mail(htmlspecialchars($_POST['email']), 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/AppMeteo/AppMeteo/public_html/php/confirm.php?id=$user_id&token=$token");
            $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
            echo '<script>document.location.href="login.php";</script>';
            exit();
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
<?php require 'include/footer.php' ?>

