<?php

    function getStatsEmbargo($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT (SELECT COUNT(*) FROM theses WHERE embargo IS null) as 'sous_embargo',
            (SELECT COUNT(*) FROM theses WHERE embargo IS NOT null) as 'sans_embargo';";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();

        }
    }

?>