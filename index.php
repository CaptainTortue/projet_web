<?php
        include("include/connexion.inc.php");
        include("ajout_personnes.php");
        include("ajout_relation.php");
        include("ajout_oai_set_specs.php");
        include("get_index_these.php");
        // mettre le contenu du fichier dans une variable
        $json = file_get_contents("exemple_json.json"); 

        // décoder le flux JSON
        $data = json_decode($json, true);

        // création variables pour thèse
        $these_sur_travaux;
        $date_soutenance;
        $etablissements_soutenance;
        $discipline;
        $president_jury;
        $nnt;
        $ecoles_doctorales;
        $embargo;
        $status;
        $source;
        $accessible;
        $langue;


        // création variables pour sujets
        $langue;
        $sujet;


        print(count($data));
        echo '<br/>';
        foreach($data as $these) {
                $idThese += 1;
                if (isset($these["these_sur_travaux"])) {
                        $these_sur_travaux = $these["these_sur_travaux"];
                        echo "1<br/>";
                }
                if (isset($these["date_soutenance"])) {
                        $date_soutenance = $these["date_soutenance"];
                        echo "2<br/>";
                }
                if (isset($these["etablissements_soutenance"])) {
                        $etablissements_soutenance = $these["etablissements_soutenance"][0]["nom"];
                        echo "3    ".$these["etablissements_soutenance"][0]["nom"]."  <br/>";
                }
                if (isset($these["discipline"])) {
                        $discipline =  $these["discipline"]["fr"];
                        echo "4<br/>";
                }
                if (isset($these["oai_set_specs"])) {
                        ajout_oai_set_specs($these["oai_set_specs"], $cnx, $idThese);
                        echo "5<br/>";
                }
                if (isset($these["president_jury"])) {
                        $president_jury = ajout_personnes($these["president_jury"], $cnx); // présent dans un fichier ajout_personne, renvoie l'id de la perssone
                        echo "6<br/>";
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

                $newthese = $cnx->prepare("INSERT INTO `theses`
                (`id`, `these_sur_travaux`, `date_soutenance`, `etablissements_soutenance`, `discipline`, `president_jury`, `nnt`, `ecoles_doctorales`, `embargo`, `status`, `source`, `estAccessible`, `langue`)
                VALUES (NULL, :these_sur_travaux, :date_soutenance, :etablissements_soutenance, :discipline, :president_jury, :nnt, :ecoles_doctorales, :embargo, :thestatus, :source, :accessible, :langue)");
                $newthese->bindParam(':these_sur_travaux', $these_sur_travaux, PDO::PARAM_STR);
                $newthese->bindParam(':date_soutenance', $date_soutenance, PDO::PARAM_STR);
                $newthese->bindParam(':etablissements_soutenance', $etablissements_soutenance, PDO::PARAM_STR);
                $newthese->bindParam(':discipline', $discipline, PDO::PARAM_STR);
                $newthese->bindParam(':president_jury', $president_jury, PDO::PARAM_INT); // recup l'id de la personne
                $newthese->bindParam(':nnt', $nnt, PDO::PARAM_STR);
                $newthese->bindParam(':ecoles_doctorales', $ecoles_doctorales, PDO::PARAM_STR, PDO::PARAM_NULL);
                $newthese->bindParam(':embargo', $embargo, PDO::PARAM_STR, PDO::PARAM_NULL);
                $newthese->bindParam(':thestatus', $status, PDO::PARAM_STR);
                $newthese->bindParam(':source', $source, PDO::PARAM_STR);
                $newthese->bindParam(':accessible', $accessible, PDO::PARAM_STR, PDO::PARAM_NULL);
                $newthese->bindParam(':langue', $langue, PDO::PARAM_STR);
                $newthese->execute();


                // partie personne et relation a mettre après la création de la thèse (sauf pour président car pas de relation)
                if (isset($these["directeurs_these"])) {
                        ajout_personnes($these["directeurs_these"], $cnx); // présent dans un fichier ajout_personne
                        ajout_relation($these["directeurs_these"],  $idThese, $cnx, 'directeurs');
                        echo "2bis<br/>";
                }
                if (isset($these["auteurs"])) {
                        ajout_personnes($these["auteurs"], $cnx); // présent dans un fichier ajout_personne
                        ajout_relation($these["auteurs"],  $idThese, $cnx, 'auteurs');
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
                if (isset($these["rapporteurs"])) {
                        ajout_personnes($these["rapporteurs"], $cnx); // présent dans un fichier ajout_personne
                        ajout_relation($these["auteurs"],  $idThese, $cnx, 'rapporteurs');
                        echo "23<br/>";
                }
                if (isset($these["sujets"])) {
                        //echo $these["sujets"]; différent 
                        echo "19<br/>";
                }
                if (isset($these["membres_jury"])) {
                        ajout_personnes($these["membres_jury"], $cnx); // présent dans un fichier ajout_personne
                        ajout_relation($these["auteurs"],  $idThese, $cnx, 'membres_jury');
                        echo "20<br/>";
                }
                if (isset($these["partenaires_recherche"])) {
                        // créer des fonctions pour celle là
                        echo "21<br/>";
                }
                if (isset($these["sujets_rameau"])) {
                        //echo $these["sujets_rameau"]; différent 
                        echo "22<br/>";
                }
                echo 'fini';
        }
        echo "gugg";
        // la requete d'exemple INSERT INTO `theses` (`id`, `these_sur_travaux`, `date_soutenance`, `etablissements_soutenance`, `discipline`, `president_jury`, `nnt`, `ecoles_doctorales`, `embargo`, `status`, `source`, `estAccessible`, `langue`, `resumes`, `auteurs`) VALUES (NULL, 'non', '2012-07-16', 'Grenoble', 'Sciences et technologie industrielles', '1', ':2012GRENI014', 'École doctorale Ingénierie - matériaux mécanique énergétique environnement procédés production (Grenoble)', null, 'soutenue', 'star', 'oui', 'fr', '1', '1');

?>