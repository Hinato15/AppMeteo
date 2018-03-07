<?php require 'include/header.php'; ?>


<?php

if(!empty($_POST))
{
    $errors = array();

    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
    {
        $errors['username'] = "Votre pseudo n'est pas valide";
    }

    if(empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
        $errors['email'] = "Votre email n'est pas valide";
    }

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm'])
    {
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }
}


?>
<h1> S'inscrire </h1>

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

<?php require 'include/footer.php'; ?>