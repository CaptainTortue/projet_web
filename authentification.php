<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">.
    <title>Document</title>
</head>
<body>
    <?php
        include("./include/connexion.inc.php");
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        if ((!isset($_POST['login'])) && (!isset($_POST['mdp']))) {
            exit("Veuillez renseigner tout les champs");
            header('Refresh:2; url=index.php');
        }
        $users = $cnx->prepare("SELECT * FROM users;");
        $users->execute();
        foreach ($users as $user) {
            if ($user["login"] == $login && password_verify($mdp, $user["password"])) {
                echo 'oui';
                $_SESSION["login"] = $login;
                header('Location: ./src/acueil.php');
                return;
            } 
        }

        echo("Identifiant/mot de passe invalide");
        header('Refresh:2; url=index.php');
        

    ?>
</body>
</html>