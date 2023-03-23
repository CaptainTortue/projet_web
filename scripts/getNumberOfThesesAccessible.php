<?php

    function getNumberOfThesesAccessible($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT COUNT(*) as 'numberOfTheses' FROM theses WHERE estAccessible='oui'";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();
        }
    }

?>