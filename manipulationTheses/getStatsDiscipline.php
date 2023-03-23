<?php

    function getStatsDiscipline($cnx, $theses) {
        if (isset($_SESSION["login"])){
            $disciplines = array();
            foreach($theses as $these) {
                if (array_key_exists($these["discipline"], $disciplines)) {
                    $disciplines[$these["discipline"]] += 1;
                } else {
                    $disciplines[$these["discipline"]] = 1;
                }
            }
            $bigDisciplines = array();
            for ($i=1; $i<15; $i++) {
                $nbMax = 0;
                $title = "";
                foreach($disciplines as $discipline=>$numberOfThese) {
                    if ($nbMax<$numberOfThese) {
                        $nbMax = $numberOfThese;
                        $title = $discipline;
                    }
                }
                $element = array();
                $element["discipline"] = $title;
                $element["nbThese"] = $nbMax;
                array_push($bigDisciplines, $element);
                unset($disciplines[$title]); 
            }
            return $bigDisciplines;
        }
    }

?>