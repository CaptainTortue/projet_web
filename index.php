<?php
        include("include/connexion.inc.php");
        include("ajout_personnes.php");
        // mettre le contenu du fichier dans une variable
        $json = file_get_contents("exemple_json.json"); 
        // décoder le flux JSON
        $data = json_decode($json, true); 
        // création variables pour thèse
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

        // création variables pour oai_set_specs
        $oai_set_specs;

        // création variables pour sujets
        $langue;
        $sujet;

        // création variable de transition pour les personnes
        $directeurs_these;

        print(count($data));
        foreach($data as $these) {
                if (isset($these["these_sur_travaux"])) {
                        $these_sur_travaux = $these["these_sur_travaux"];
                        echo "1<br/>";
                }
                if (isset($these["date_soutenance"])) {
                        $date_soutenance = $these["date_soutenance"];
                        echo "2<br/>";
                }
                if (isset($these["directeurs_these"])) {
                        ajout_personnes($these["directeurs_these"]); // présent dans un fichier ajout_personne
                        echo "2bis<br/>";
                }
                if (isset($these["etablissements_soutenance"])) {
                        $etablissements_soutenance = $these["etablissements_soutenance"][0]["nom"];
                        echo "3<br/>";
                }
                if (isset($these["discipline"])) {
                        $discipline =  $these["discipline"]["fr"];
                        echo "4<br/>";
                }
                if (isset($these["oai_set_specs"])) {
                        //echo $these["oai_set_specs"]; different
                        echo "5<br/>";
                }
                if (isset($these["president_jury"])) {
                        ajout_personnes($these["president_jury"]); // présent dans un fichier ajout_personne
                        echo "6<br/>";
                }
                if (isset($these["iddoc"])) {
                        $iddoc =  $these["iddoc"]; // correspond a idThese
                        echo "7<br/>";
                }
                if (isset($these["nnt"])) {
                        $nnt = $these["nnt"];
                        echo "8<br/>";
                }
                if (isset($these["ecoles_doctorales"])) {
                        $ecoles_doctorales = $these["ecoles_doctorales"][0]["nom"];
                        echo "9<br/>";
                }
                if (isset($these["embargo"])) {
                        $embargo = $these["embargo"];
                        echo "10<br/>";
                }
                if (isset($these["status"])) {
                        $status = $these["status"];
                        echo "11<br/>";
                }
                if (isset($these["source"])) {
                        $source = $these["source"];
                        echo "12<br/>";
                }
                if (isset($these["accessible"])) {
                        $accessible = $these["accessible"];
                        echo "13<br/>";
                }
                if (isset($these["langue"])) {
                        $langue = $these["langue"];
                        echo "14<br/>";
                }
                if (isset($these["code_etab"])) {
                        $code_etab = $these["code_etab"];
                        echo "15<br/>";
                }
                if (isset($these["auteurs"])) {
                        ajout_personnes($these["auteurs"]); // présent dans un fichier ajout_personne
                        echo "16<br/>";
                }
                if (isset($these["titres"])) {
                        //echo $these["titres"]; différent 
                        echo "17<br/>";
                }
                if (isset($these["resumes"])) {
                        //echo $these["resumes"]; différent 
                        echo "18<br/>";
                }
                if (isset($these["sujets"])) {
                        //echo $these["sujets"]; différent 
                        echo "19<br/>";
                }
                if (isset($these["membres_jury"])) {
                        ajout_personnes($these["membres_jury"]); // présent dans un fichier ajout_personne
                        echo "20<br/>";
                }
                if (isset($these["partenaires_recherche"])) {
                        ajout_personnes($these["partenaires_recherche"]); // présent dans un fichier ajout_personne
                        echo "21<br/>";
                }
                if (isset($these["sujets_rameau"])) {
                        //echo $these["sujets_rameau"]; différent 
                        echo "22<br/>";
                }
                if (isset($these["rapporteurs"])) {
                        ajout_personnes($these["rapporteurs"]); // présent dans un fichier ajout_personne
                        echo "23<br/>";
                }
        }
        echo "gugg";
?>