<?php
    function ajout_personnes($personnes, $cnx) {
        foreach ($personnes as $personne) {
            $idref = NULL;
            if (isset($personne["nom"])) {
                    $nom = $personne["nom"];
            }
            if (isset($personne["prenom"])) {
                    $prenom = $personne["prenom"];
            }
            if (isset($personne["idref"])) {
                    $idref = $personne["idref"];
            }
            echo '<br/>';
            $personneExiste = $cnx->prepare("SELECT id FROM `personnes` WHERE nom=:nom AND prenom=:prenom;"); // ne pas vérifier idref null!=null d'après le where
            $personneExiste->bindParam(':nom', $nom, PDO::PARAM_STR);
            $personneExiste->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $personneExiste->execute();
            foreach ($personneExiste as $id) {
                return $id;
            }
            // 'existe pas';
            $idpersonne = 1;
            $rechercheidpersonne = $cnx->prepare("SELECT MAX(id) FROM `personnes`;");
            $rechercheidpersonne->execute();
            foreach ($rechercheidpersonne as $id) {
                $idpersonne = $id["MAX(id)"]+1;
            }
            $sth = $cnx->prepare('INSERT INTO `personnes` (`id`, `nom`, `prenom`, `idref`) VALUES (:idpersonne, :nom, :prenom, :idref)');
            $sth->bindParam(':idpersonne', $idpersonne, PDO::PARAM_STR);
            $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
            $sth->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $sth->bindParam(':idref', $idref, PDO::PARAM_INT);
            $sth->execute();
            return $idpersonne;
        }
    }
?>
