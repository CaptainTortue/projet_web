<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- hightchart -->
        <script src="https://code.highcharts.com/highcharts.js"></script>

</head>
<body>
<hr>
    <main>
            <div class="formulaire">
                <h1>Connexion</h1>
                <form action="reussi.php" method="POST">
                    <b>Nom:</b> <input type="text" name="nom" required class="champs nom"/>
                    <b>Mot de passe:</b><input type="text" name="mdp" required class="champs mdp"/><br />
                    <input type="reset" name="reset" value="Effacez" class = "boutton_formulaire"/> <input type="submit" name="submit" value="Validez" class = "boutton_formulaire"/>
                </form>
            </div>
    </main>
<?php
        // si on veut extraire le jeu de données
        //include("extract_theses.php");
        //extract_theses($idThese, $cnx);
?>        
</body>
</html>


