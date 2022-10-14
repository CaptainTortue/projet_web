<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("./include/connexion.inc.php");
        $nom = $_POST['nom'];
        $mdp = $_POST['mdp'];

        if ((!isset($_POST['nom'])) && (!isset($_POST['mdp']))) {
            exit("Veuillez réessayer");
        }
        if ("test" == $nom && "test" == $mdp) {
            echo("<p>uhufe</p>");
        }

    ?>
    <p>ufzehuie</p>
</body>
</html>