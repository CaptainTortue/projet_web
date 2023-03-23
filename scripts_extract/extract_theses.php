<?php
        // attention il faut déjà avoir une base de donnée avec la bonne structure qui contient les tables
        include("get_index_these.php");
        include("ajout_personnes.php");
        include("ajout_partenaires.php");
        include("ajout_relation.php");
        include("ajout_texte.php");
        include("ajout_etablissements.php");
        include("ajout_sujets.php");
        include("ajout_oai_set_specs.php");

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

        function extract_theses($cnx) {
                $idThese = get_index_these($cnx);
                // mettre le contenu du fichier dans une variable
                //$json = file_get_contents("exemple_json.json"); 
                $json = file_get_contents("extract_theses.json"); 

                // décoder le flux JSON
                $data = json_decode($json, true);

                foreach($data as $these) {
                        $idThese += 1;
                        if (isset($these["these_sur_travaux"])) {
                                $these_sur_travaux = $these["these_sur_travaux"];
                                //echo "1<br/>";
                        }
                        if (isset($these["date_soutenance"])) {
                                $date_soutenance = $these["date_soutenance"];
                                //echo "2<br/>";
                        }
                        if (isset($these["etablissements_soutenance"])) {
                                $etablissements_soutenance = ajout_etablissements($these["etablissements_soutenance"], $cnx);
                                echo "3    ".$these["etablissements_soutenance"][0]["nom"]."  <br/>";
                        }
                        if (isset($these["discipline"]["fr"])) {
                                $discipline =  $these["discipline"]["fr"];
                                //echo "4<br/>";
                        }
                        if (isset($these["oai_set_specs"])) {
                                ajout_oai_set_specs($these["oai_set_specs"], $cnx, $idThese);
                                //echo "5<br/>";
                        }
                        if (isset($these["president_jury"])) {
                                $president_jury = ajout_personnes($these["president_jury"], $cnx); // présent dans un fichier ajout_personne, renvoie l'id de la perssone
                                // echo "6<br/>";
                        }
                        if (isset($these["nnt"])) {
                                $nnt = $these["nnt"];
                                //echo "8<br/>";
                        }
                        if (isset($these["ecoles_doctorales"][0]["nom"])) {
                                $ecoles_doctorales = $these["ecoles_doctorales"][0]["nom"];
                                //echo "9<br/>";
                        }
                        if (isset($these["embargo"])) {
                                $embargo = $these["embargo"];
                                //echo "10<br/>";
                        }
                        if (isset($these["status"])) {
                                $status = $these["status"];
                                //echo "11<br/>";
                        }
                        if (isset($these["source"])) {
                                $source = $these["source"];
                                //echo "12<br/>";
                        }
                        if (isset($these["accessible"])) {
                                $accessible = $these["accessible"];
                                //echo "13<br/>";
                        }
                        if (isset($these["langue"])) {
                                $langue = $these["langue"];
                                //echo "14<br/>";
                        }

                        $newthese = $cnx->prepare("INSERT INTO `theses`
                        (`id`, `these_sur_travaux`, `date_soutenance`, `etablissements_soutenance`, `discipline`, `president_jury`, `nnt`, `ecoles_doctorales`, `embargo`, `status`, `source`, `estAccessible`, `langue`)
                        VALUES (:idThese, :these_sur_travaux, :date_soutenance, :etablissements_soutenance, :discipline, :president_jury, :nnt, :ecoles_doctorales, :embargo, :thestatus, :source, :accessible, :langue)");
                        $newthese->bindParam(':idThese', $idThese, PDO::PARAM_INT);
                        $newthese->bindParam(':these_sur_travaux', $these_sur_travaux, PDO::PARAM_STR);
                        $newthese->bindParam(':date_soutenance', $date_soutenance, PDO::PARAM_STR);
                        $newthese->bindParam(':etablissements_soutenance', $etablissements_soutenance, PDO::PARAM_STR);
                        $newthese->bindParam(':discipline', $discipline, PDO::PARAM_STR);
                        $newthese->bindParam(':president_jury', $president_jury, PDO::PARAM_INT, PDO::PARAM_NULL); // recup l'id de la personne
                        $newthese->bindParam(':nnt', $nnt, PDO::PARAM_STR);
                        $newthese->bindParam(':ecoles_doctorales', $ecoles_doctorales, PDO::PARAM_STR, PDO::PARAM_NULL);
                        $newthese->bindParam(':embargo', $embargo, PDO::PARAM_STR, PDO::PARAM_NULL);
                        $newthese->bindParam(':thestatus', $status, PDO::PARAM_STR);
                        $newthese->bindParam(':source', $source, PDO::PARAM_STR);
                        $newthese->bindParam(':accessible', $accessible, PDO::PARAM_STR, PDO::PARAM_NULL);
                        $newthese->bindParam(':langue', $langue, PDO::PARAM_STR);
                        //$newthese->debugDumpParams();
                        $newthese->execute();
                        


                        // partie personne et relation a mettre après la création de la thèse (sauf pour président car pas de relation)
                        if (isset($these["directeurs_these"])) {
                                ajout_personnes($these["directeurs_these"], $cnx); // présent dans un fichier ajout_personne
                                ajout_relation($these["directeurs_these"],  $idThese, $cnx, 'directeurs');
                                //echo "2bis<br/>";
                        }
                        if (isset($these["auteurs"])) {
                                ajout_personnes($these["auteurs"], $cnx); // présent dans un fichier ajout_personne
                                ajout_relation($these["auteurs"],  $idThese, $cnx, 'auteurs');
                                //echo "16<br/>";
                        }
                        if (isset($these["titres"]["fr"])) {
                                ajout_texte("titre", $idThese, $cnx, $these["titres"]["fr"]);
                                //echo "17<br/>";
                        }
                        if (isset($these["resumes"]["fr"])) {
                                ajout_texte("resume", $idThese, $cnx, $these["resumes"]["fr"]);
                                //echo "18<br/>";
                        }
                        if (isset($these["rapporteurs"])) {
                                ajout_personnes($these["rapporteurs"], $cnx); // présent dans un fichier ajout_personne
                                ajout_relation($these["rapporteurs"],  $idThese, $cnx, 'rapporteurs');
                                //echo "23<br/>";
                        }
                        if (isset($these["sujets"]["fr"])) {
                                ajout_sujets($idThese, $cnx, $these["sujets"]["fr"]);
                                //echo "19<br/>";
                        }
                        if (isset($these["membres_jury"])) {
                                ajout_personnes($these["membres_jury"], $cnx); // présent dans un fichier ajout_personne
                                ajout_relation($these["membres_jury"],  $idThese, $cnx, 'membres_jury');
                                //echo "20<br/>";
                        }
                        if (isset($these["partenaires_recherche"])) {
                                ajout_partenaires($idThese, $cnx, $these["partenaires_recherche"]);
                                echo "21<br/>";
                        }
                }
        }

?>