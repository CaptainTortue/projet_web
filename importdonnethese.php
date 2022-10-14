<?php
    include("connexion.inc.php");
    // mettre le contenu du fichier dans une variable
    $data = file_get_contents("exemple_json.json"); 
    // décoder le flux JSON
    $obj = json_decode($data); 
    // accéder à l'élément approprié
    echo $obj[0];
?> 