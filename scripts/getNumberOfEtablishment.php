<?php

    function getNumberOfEtablishment($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT COUNT(DISTINCT etablissements_soutenance) as 'numberOfEtablishment' FROM theses";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();
        }
    }

?>