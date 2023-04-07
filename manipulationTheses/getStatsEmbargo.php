<?php

    function getStatsEmbargo($theses) {
        if (isset($_SESSION["login"])){
            $nbembargo = 0;
            $nbnonembargo = 0;
            foreach($theses as $these) {
                if ($these["embargo"]!=null) {
                    $nbembargo += 1;
                } else {
                    $nbnonembargo += 1;
                }
            }
            return array($nbembargo, $nbnonembargo);


        }
    }

?>