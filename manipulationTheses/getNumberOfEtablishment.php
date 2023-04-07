<?php

    function getNumberOfEtablishment($theses) {
        if (isset($_SESSION["login"])){
            /*
            version appel avec la bdd
            $request = "SELECT COUNT(DISTINCT etablissements_soutenance) as 'numberOfEtablishment' FROM theses";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses[0];
            */
            $etablishment = array();
            foreach($theses as $these) {
                if (!in_array($these["etablissements_soutenance"], $etablishment)) {
                    array_push($etablishment, $these["etablissements_soutenance"]);
                }  
            }
            return count($etablishment);
        }
    }

?>