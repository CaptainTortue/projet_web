<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <meta name="robots" content="noindex, nofollow">
        <link rel="stylesheet" href="./css/authentification.css">

</head>
<body>
<hr>
    <main>
            <div class="formulaire">
                <h1>Connexion</h1>
                <form action="authentification.php" method="POST">
                    <b>Login:</b> <input type="text" name="login" required class="champs login"/>
                    <b>Mot de passe:</b><input type="text" name="mdp" required class="champs mdp"/><br />
                    <input type="reset" name="reset" value="Effacez" class = "boutton_formulaire"/> <input type="submit" name="submit" value="Validez" class = "boutton_formulaire"/>
                </form>
            </div>
    </main>
<?php
        // si on veut extraire le jeu de données
        //include("include/connexion.inc.php");
        //include("./scripts_extract/extract_theses.php");
        //extract_theses($cnx);
?>        
</body>
</html>


