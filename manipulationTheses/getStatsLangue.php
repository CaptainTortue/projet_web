<?php

    function getStatsLangue($theses) {
        if (isset($_SESSION["login"])) {

            $langues = array();
            foreach($theses as $these) {
                if (array_key_exists($these["langue"], $langues)) {
                    $langues[$these["langue"]] += 1;
                } else {
                    $langues[$these["langue"]] = 1;
                }
            }
            $bigLangues = array();
            for ($i=1; $i<15; $i++) {
                $nbMax = 0;
                $title = "";
                foreach($langues as $langue=>$numberOfThese) {
                    if ($nbMax<$numberOfThese) {
                        $nbMax = $numberOfThese;
                        $title = $langue;
                    }
                }
                if ($nbMax>0) {
                    $element = array();
                    $element["langue"] = $title;
                    $element["nbThese"] = $nbMax;
                    array_push($bigLangues, $element);
                    unset($langues[$title]);
                }
            }
            return $bigLangues;
        }
    }

?>