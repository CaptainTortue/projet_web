<?php

    function getNumberOfTheses($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT COUNT(*) as 'numberOfTheses' FROM theses";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();
        }
    }

?>