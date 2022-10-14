<?php
        include("include/connexion.inc.php");
        // mettre le contenu du fichier dans une variable
        $json = file_get_contents("exemple_json.json"); 
        // décoder le flux JSON
        $data = json_decode($json, true); 
        // accéder à l'élément approprié
        $these_sur_travaux;
        $date_soutenance;
        $directeurs_these;
        $discipline;
        $oai_set_specs;
        $president_jury;
        $iddoc;
        $nnt;
        $ecoles_doctorales;
        $embargo;
        $status;
        $source;
        $accessible;
        $langue;
        $code_etab;
        $auteurs;
        $accessible;
        print(count($data));
        foreach($data as $these) {
                if (isset($these["these_sur_travaux"])) {
                        echo $these["these_sur_travaux"];
                        echo "<br/>";
                }
                if (isset($these["date_soutenance"])) {
                        echo $these["date_soutenance"];
                        echo "<br/>";
                }
                if (isset($these["directeurs_these"])) {
                        //echo $these["directeurs_these"]; different
                        echo "<br/>";
                }
                if (isset($these["etablissements_soutenance"])) {
                        echo $these["etablissements_soutenance"][0]["nom"];
                        echo "<br/>";
                }
                if (isset($these["discipline"])) {
                        echo $these["discipline"]["fr"];
                        echo "<br/>";
                }
                if (isset($these["oai_set_specs"])) {
                        //echo $these["oai_set_specs"]; different
                        echo "<br/>";
                }
                if (isset($these["president_jury"])) {
                        //echo $these["president_jury"]; different
                        echo "<br/>";
                }
                if (isset($these["iddoc"])) {
                        echo $these["iddoc"]; // correspond a idThese
                        echo "<br/>";
                }
                if (isset($these["nnt"])) {
                        echo $these["nnt"];
                        echo "<br/>";
                }
                if (isset($these["ecoles_doctorales"])) {
                        echo $these["ecoles_doctorales"][0]["nom"];
                        echo "<br/>";
                }
                if (isset($these["embargo"])) {
                        echo $these["embargo"];
                        echo "<br/>";
                }
                if (isset($these["status"])) {
                        echo $these["status"];
                        echo "<br/>";
                }
                if (isset($these["source"])) {
                        echo $these["source"];
                        echo "<br/>";
                }
                if (isset($these["accessible"])) {
                        echo $these["accessible"];
                        echo "<br/>";
                }
                if (isset($these["langue"])) {
                        echo $these["langue"];
                        echo "<br/>";
                }
                if (isset($these["code_etab"])) {
                        echo $these["code_etab"];
                        echo "<br/>";
                }
                if (isset($these["auteurs"])) {
                        //echo $these["auteurs"]; différent 
                        echo "<br/>";
                }
        }
        echo "gugg";
?>