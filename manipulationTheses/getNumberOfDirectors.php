<?php

    function getNumberOfDirectors($cnx, $theses) {
        if (isset($_SESSION["login"])){
            $directors = array();
            foreach($theses as $these) {
                $request = "SELECT idPersonne FROM directeurs WHERE idThese = :idThese";
                $request = $cnx->prepare($request);
                $request->bindParam(':idThese', $these['id'], PDO::PARAM_INT);  
                $request->execute();
                foreach($request as $idPersonne) {
                    if (!in_array($idPersonne["idPersonne"], $directors)) {
                        array_push($directors, $idPersonne["idPersonne"]);
                    }
                }
            }
            return count($directors);
        }
    }

?>