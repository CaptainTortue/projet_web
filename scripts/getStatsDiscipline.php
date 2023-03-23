<?php

    function getStatsDiscipline($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT discipline, COUNT(*) as nbThese FROM theses GROUP BY discipline ORDER BY nbThese Desc LIMIT 20;";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();

        }
    }

?>