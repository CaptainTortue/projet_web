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
    <?php if (isset($_SESSION["login"])) {header('Location=connection.html');} ?>
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
        <li class="nav-item">
            <p class="nav-link">Type de personne</p>
        </li>
        <li class="nav-item">
    <form action="acueil.php" method="POST">
        <select class="nav-link " name="type" id="type">

                <option value="auteurs">Autheur</option>
                <option value="directeurs">Directeur</option>
                <option value="rapporters">Rapporter</option>
            </select>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div>
        <b>Nom:</b> <input type="text" name="nom"/>
        <b>Prenom:</b> <input type="text" name="prenom"/>
        <b>Titre</b><input type="text" name="titre"/><br />
        <input type="reset" name="reset" value="Effacez"/> <input type="submit" name="submit" value="Rechercher"/>
    </form>
</div>


<?php
        include("../include/connexion.inc.php");
        include("get_theses.php");
        $result = get_these($cnx);
        /* test de base (peut encore etre utile) 
        $request ="SELECT * FROM theses";
        $theses = $cnx->prepare($request);
        $theses->execute();
        foreach($theses as $these) {
            echo $these["id"];
        } */

                
        if (isset($result)) {
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
            }
        }
?>     
<footer> 
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <p class="navbar-nav mb-2 mb-lg-0">Tristan Martinez</p>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0" style="margin-left: auto;">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href = './reporting.html'>Reporting</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</footer>   
</body>
</html>
