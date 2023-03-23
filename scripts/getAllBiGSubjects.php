<?php

    function getAllBiGSubjects($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT sujet FROM sujets ORDER BY sujet ASC LIMIT 50";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();
        }
    }

?>