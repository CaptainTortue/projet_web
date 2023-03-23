<?php

    function getStatsEmbargo($cnx) {
        if (isset($_SESSION["login"])){
            $request = "SELECT (SELECT COUNT(*) FROM theses WHERE embargo IS null) as 'sous_embargo',
            (SELECT COUNT(*) FROM theses WHERE embargo IS NOT null) as 'sans_embargo';";
            $theses = $cnx->prepare($request);
            $theses->execute();
            return $theses->fetchAll();
            $nbembargo = 0;
            $nbnonembargo = 0;
            foreach($theses as $these) {
                if ($these["embargo"]==NULL) {
                    $nbembargo += 1;
                } else {
                    $nbnonembargo += 1;
                }
            }
            return array($nbembargo, $nbnonembargo);


        }
    }

?>