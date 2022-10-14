<?php

    /*
    * création d'objet PDO de la connexion qui sera représenté par la variable $cnx
    */
    $nom = "root";
    $mdp = "Tristan.1999";

    // exec() tout est stocké dans argv pour récupe les paramètre (ou les retours)
    // var_dump() sert de debug, affiche le type taille de la variable
    
    try {
        $cnx = new PDO('mysql:host=localhost;dbname=projet_web', $nom, $mdp);
    }
    catch (PDOException $e) {
        echo "ERREUR : La connexion a échouée";

        /* Utiliser l'instruction suivante pour afficher le détail de erreur sur la
        * page html. Attention c'est utile pour débugger mais cela affiche des
        * informations potentiellement confidentielles donc éviter de le faire pour un
        * site en production.*/
        echo "Error: " . $e;
    }
?>