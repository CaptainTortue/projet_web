<?php
    function ajout_etablissements($etablissements, $cnx) {
        foreach ($etablissements as $etablissement) {
            $idref = NULL;
            if (isset($etablissement["nom"])) {
                    $nom = $etablissement["nom"];
            }
            if (isset($etablissement["idref"])) {
                    $idref = $etablissement["idref"];
            }
            $etablissementExiste = $cnx->prepare("SELECT id FROM `etablissements` WHERE nom=:nom"); // ne pas vérifier idref null!=null d'après le where
            $etablissementExiste->bindParam(':nom', $nom, PDO::PARAM_STR);
            $etablissementExiste->execute();
            foreach ($etablissementExiste as $id) {
                return $id;
            }
            // 'existe pas';
            $idetablissement = 1;
            $rechercheidetablissement = $cnx->prepare("SELECT MAX(id) FROM `etablissements`;");
            $rechercheidetablissement->execute();
            foreach ($rechercheidetablissement as $id) {
                $idetablissement = $id["MAX(id)"]+1;
            }
            $sth = $cnx->prepare('INSERT INTO `etablissements` (`id`, `nom`, `idref`) VALUES (:idetablissement, :nom, :idref)');
            $sth->bindParam(':idetablissement', $idetablissement, PDO::PARAM_STR);
            $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
            $sth->bindParam(':idref', $idref, PDO::PARAM_STR);
            $sth->execute();
            return $idetablissement;
        }
    }
?>
