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
<div>
    <h1>Recherche</h1>
    <form action="acueil.php" method="POST">
        <b>Nom:</b> <input type="text" name="nom"/>
        <b>Prenom:</b> <input type="text" name="prenom"/>
        <b>Titre</b><input type="text" name="titre"/><br />
        <input type="reset" name="reset" value="Effacez"/> <input type="submit" name="submit" value="Rechercher"/>
    </form>
</div>
<?php
        include("include/connexion.inc.php");
        include("scripts/get_theses.php");
        $result = get_these($cnx);
        /* test de base (peut encore etre utile) 
        $request ="SELECT * FROM theses";
        $theses = $cnx->prepare($request);
        $theses->execute();
        foreach($theses as $these) {
            echo $these["id"];
        } */
        
        if (isset($result)) {
            foreach($result as $these) {
                echo $these["id"]."     ".$these["etablissements_soutenance"]."     ".$these["etablissements_soutenance"]."     ".$these["etablissements_soutenance"]."     ".$these["etablissements_soutenance"];
                if (isset($these["titre"])) {
                    echo $these["titre"]."<br/>";
                }
            }
        }
        // si on veut extraire le jeu de données
        //include("extract_theses.php");
        //extract_theses($idThese, $cnx);
?>        
</body>
</html>
