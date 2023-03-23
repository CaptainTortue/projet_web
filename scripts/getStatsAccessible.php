<?php

    function getStatsAccessible($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT (SELECT COUNT(*) FROM theses WHERE estAccessible='oui') as 'nonAccessible',
            (SELECT COUNT(*) FROM theses WHERE estAccessible='non') as 'Accessible';";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();

        }
    }

?>