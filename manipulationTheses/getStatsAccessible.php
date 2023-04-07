<?php

    function getStatsAccessible($theses) {
        if (isset($_SESSION["login"])){
            $nbaccessible = 0;
            $nbnonaccessible = 0;
            foreach($theses as $these) {
                if ($these["estAccessible"]=="oui") {
                    $nbaccessible += 1;
                } else {
                    $nbnonaccessible += 1;
                }
            }
            return array($nbaccessible, $nbnonaccessible);

        }
    }

?>