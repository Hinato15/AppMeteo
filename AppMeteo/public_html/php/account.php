<?php
$title = "Votre Compte";
require_once 'include/functions.php';
require_once 'include/db.php';
logged_only();

    /* Changement de mot de passe */

if(isset($_POST['password']))
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
    $searchs = $pdo->prepare('SELECT id, the_research,temperature_research,conditions_research,DATE_FORMAT(date_research,\'%d/%m/%Y à %Hh %imin %ss\') as dateSearch,user_id_research FROM search WHERE user_id_research = ? ORDER BY date_research DESC LIMIT 0, 5');
    $searchs->execute([$user_id]);

    /* Envoie de la recherche */

    if(isset($_POST["research"]))
    {
        $user_id = $_SESSION['auth']->id;
        $research = htmlspecialchars($_POST["research"]);
        $temperature = $_POST["temperature"];
        $conditions = $_POST["conditions"];

        $req = $pdo->prepare("INSERT INTO search SET the_research = ?, user_id_research = ?, temperature_research = ?, conditions_research = ?, date_research = NOW()");
        $req->execute([$research, $user_id, $temperature, $conditions]);
        echo '<script>document.location.href="account.php";</script>';
    }


?>

<?php require 'include/header.php' ?>

    <h1>Bonjour <?= $_SESSION['auth']->username ?></h1>

    <br><br>

    <h2>Recherche Rapide</h2> <br>

    <form action="" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <input type="text" id="ville" placeholder="" name="research" class="form-control ">
                </div>
                <div class="col-lg-5">
                    <input id="temperature" name="temperature" class="weather"> C° (<input id="conditions" name="conditions" class="weather">) <br>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary">Enregistrer ma recherche</button>
                </div>
            </div>
            <span id="warning_text">Statement</span>
        </div>

    </form>

    <br>

    <h2>Recherches Enregistrer</h2>
    <ul id="search_list">
        <?php foreach ($searchs as $search): ?>

            <li class="search_content">
                <?= $search->the_research ?> <?= $search->temperature_research ?>C° (<?= $search->conditions_research ?>) (Recherche faite le <?= $search->dateSearch ?> )
            </li>

        <?php endforeach; ?>
    </ul>

    <br><br>

    <h2>Changer votre mot de passe</h2> <br>
    <form action="" method="post">

    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Nouveau mot de passe">
    </div>

    <div class="form-group">
        <input type="password" class="form-control" name="password_confirm" placeholder="Confirmation du mot de passe">
    </div>

        <button class="btn btn-primary">Confirmer</button>

    </form>

<?php require 'include/footer.php' ?>