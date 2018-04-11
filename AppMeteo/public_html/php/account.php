<?php
$title = "Votre Compte";
require_once 'include/functions.php';
require_once 'include/db.php';
logged_only();

    /* Changement de mot de passe */

if(!empty($_POST))
{
    if(empty(htmlspecialchars($_POST['password'])) || htmlspecialchars($_POST['password']) != htmlspecialchars($_POST['password_confirm']) )
    {
        $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas";
    } else {
        $user_id = $_SESSION['auth']->id;
        $password = password_hash( htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
        $req = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }
}

    /* Récupération des recherche */

    $user_id = $_SESSION['auth']->id;
    $searchs = $pdo->prepare('SELECT * FROM search WHERE user_id_research = ? ORDER BY date_research DESC LIMIT 0, 5');
    $searchs->execute([$user_id]);

?>

<?php require 'include/header.php' ?>

    <h1>Bonjour <?= $_SESSION['auth']->username ?></h1>

    <br><br>

    <h2>Dernière Recherches</h2>
    <ul id="search_list">
        <?php foreach ($searchs as $search): ?>

            <li class="search_content">
                <?= $search->the_research; ?>
            </li>

        <?php endforeach; ?>
    </ul>

    <br><br>

    <form action="" method="post">

    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Changer de mot de passe">
    </div>

    <div class="form-group">
        <input type="password" class="form-control" name="password_confirm" placeholder="Confirmation du mot de passe">
    </div>

        <button class="btn btn-primary">Confirmer</button>

    </form>

<?php require 'include/footer.php' ?>