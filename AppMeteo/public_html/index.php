<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>App Meteo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/ico" href="AppMeteo.png"/>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/weather-icons-master/css/weather-icons.css" rel="stylesheet">
    </head>
    <body>
    <div id="main_container">
            
        <nav id="navbar">
            <h2><a href="index.php">AppMeteo</a></h2>
            <ul>
                <?php if(isset($_SESSION['auth'])): ?>
                    <li><a href="php/account.php">Mon Compte</a></li>
                        <li><a href="php/logout.php">Deconnexion</a></li>
                <?php else: ?>
                    <li><a href="php/register.php">S'inscrire</a></li>
                    <li><a href="php/login.php">Se Connecter</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div id="weather_container">
            <section id="app">
                <h1>
                    <input id="ville" placeholder=" "> </input>
                    <span class="tooltip">Tapez une autre ville si vous le souhaitez</span>
                </h1>
                <span id="warning_text">Statement</span>
                    <i class="wi"></i>
                <h2>
                    <span id="temperature"></span> C° (<span id="conditions"></span>)
                </h2>
            </section>
        </div>
  </div>
        <script src="js/app.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrKU0MzYVwTIiZp6J2eYdb9R4kRGNybaM&libraries=places&callback=activatePlacesSearch" async defer></script>
      </body>
  </html>
