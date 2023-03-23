<?php

    function getStatsLangue($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT langue, COUNT(*) as nbThese FROM theses GROUP BY langue ORDER BY nbThese Desc LIMIT 20;";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();

        }
    }

?>