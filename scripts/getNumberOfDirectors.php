<?php

    // obselet
    function getNumberOfDirectors($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT COUNT(*) as 'numberOfDirectors' FROM directeurs";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();
        }
    }

?>