<?php

    function getNumberOfThesesAccessible($cnx, $theses) {
        if (isset($_SESSION["login"])){
            $nbaccessible = 0;
            foreach($theses as $these) {
                if ($these["estAccessible"]=="oui") {
                    $nbaccessible += 1;
                }  
            }
            return $nbaccessible;
        }
    }

?>