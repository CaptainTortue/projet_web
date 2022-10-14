<?php
    include("include/connexion.inc.php");
    function ajout_personnes($personnes) {
        foreach ($personnes as $personne) {
            if (isset($personne["nom"])) {
                    $nom = $personne["nom"];
            }
            if (isset($personne["prenom"])) {
                    $prenom = $personne["prenom"];
            }
            if (isset($personne["idref"])) {
                    $idref = $personne["idref"];
            }
            echo "uoereehoui00";
        }
    }
    $result = $cnx -> exec("INSERT INTO personnes ('nom', 'prenom', 'idref') VALUES ('".$nom."', '".$prenom."', ".$idref.");");
?>
