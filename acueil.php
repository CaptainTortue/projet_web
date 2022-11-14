<!DOCTYPE html>
<?php session_start(); ?>
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
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <h1>Recherche</h1>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0" style="margin-left: auto;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Acueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Reconnexion</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Type de personne</a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Autheur</a></li>
            <li><a class="dropdown-item" href="#">Directeur</a></li>
            <li><a class="dropdown-item" href="#">Rapporter</a></li>
            <li><hr class="dropdown-divider"></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div>
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
            // possiblité 1 echo '<ul class="list-group">';
            echo '<div class="accordion" id="these">';
            $id = 0;
            foreach($result as $these) {
                echo 
                '<div class="accordion-item" style="border-width: 4px; border-color: black;">
                    <h2 class="accordion-header" id="heading'.$id.'">
                    <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$id.'" aria-expanded="true" aria-controls="collapse'.$id.'">
                        '.$these["id"]."   ".$these["discipline"]."     ".$these["etablissements_soutenance"]."     ".$these["date_soutenance"]."     ".$these["status"]."     ".$these["langue"]."     ".$these["nnt"]."     ".$these["nom"]."     ".$these["prenom"].'
                    </button>
                    </h2>
                    <div id="collapse'.$id.'" class="accordion-collapse collapse" aria-labelledby="heading'.$id.'" data-bs-parent="#these">
                    <div class="accordion-body">';
                    
                    if (isset($these["titre"])) {
                        echo $these["titre"];
                    }
                    if (isset($these["resume"])) {
                        echo $these["resume"];
                    }
                    echo '</div>
                    </div>
                </div>';
                $id += 1;
                /* possibilité 1
                echo '<li class="list-group-item-primary" style="margin-bottom: 2em;"> '
                .$these["id"]."   ".$these["discipline"]."     ".$these["etablissements_soutenance"]."     ".$these["date_soutenance"]."     ".$these["status"]."     ".$these["langue"]."     ".$these["nnt"];
                
                if (isset($these["titre"])) {
                    echo '<!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal'.$id.'">
                    '.$these["titre"].'
                    </button>';
                    echo '
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal'.$id.'" tabindex="-1" aria-labelledby="exampleModalLabel'.$id.'" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel'.$id.'">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: withe;">';
                    if (isset($these["resume"])) {
                        echo $these["resume"];
                    } else {
                        echo '<p>Pas de résumé pour cette thèse</p>';
                    }
                    echo '
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>';                    
                
                }
                echo '</li>';
                */
            }
        }
        // si on veut extraire le jeu de données
        //include("extract_theses.php");
        //extract_theses($idThese, $cnx);
?>        
</body>
</html>
