<?php
$title = "Connexion";
require 'include/functions.php';
session_start();
logged_only_login();
?>
<?php
if(!empty($_POST) && !empty(htmlspecialchars($_POST['username'])) && !empty(htmlspecialchars($_POST['password'])) )
{
    require 'include/db.php';

    $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();

    if($user != null && password_verify(htmlspecialchars($_POST['password']), $user->password))
    {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
        echo '<script>document.location.href="account.php";</script>';
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect';
    }
}
?>
<?php require 'include/header.php' ?>

    <h1>Se Connecter</h1>

    <form action="" method="POST">
        <div form="form-group">
            <label>Pseudo ou Email</label>
            <input type="text" name="username" class="form-control" required/>
        </div>

        <div form="form-group">
            <label for="">Mot de Passe</label>
            <input type="password" name="password" class="form-control" required/>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">Se Connecter</button>
    </form>

<?php require 'include/footer.php' ?>