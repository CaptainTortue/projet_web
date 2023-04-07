
<?php

    function getStatsDate($cnx, $date) {
        if (isset($_SESSION["login"])){
            if ($date=="month") {
                $request = "SELECT
                    EXTRACT(month FROM date_soutenance) AS thedate,
                    COUNT(*) AS nbTheses 
                FROM theses
                WHERE date_soutenance>'1985-01-01'
                GROUP BY thedate;";
            } else {
                $request = "SELECT
                    EXTRACT(year FROM date_soutenance) AS thedate,
                    COUNT(*) AS nbTheses 
                FROM theses
                WHERE date_soutenance>'1985-01-01'
                GROUP BY thedate;";
            }
            $theses = $cnx->prepare($request);
            //$theses->bindParam(':date', $date, PDO::PARAM_STR);
            $theses->execute();
            return $theses->fetchAll();

            /* TODO faire sans la bdd avec la liste pour graphique dynamique */
        }
    }

?>