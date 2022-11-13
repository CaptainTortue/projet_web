<?php

function ajout_partenaires($idThese, $cnx, $partenaires)
{        
    foreach ($partenaires as $partenaire) {
        $idref = NULL;
        if (isset($partenaire["nom"])) {
                $nom = $partenaire["nom"];
        }
        if (isset($partenaire["type"])) {
                $type = $partenaire["type"];
        }
        if (isset($partenaire["idref"])) {
                $idref = $partenaire["idref"];
        }
        $partenaireExiste = $cnx->prepare("SELECT id FROM `partenaires` WHERE nom=:nom AND letype=:letype AND idref=:idref;"); // ne pas vérifier idref null!=null d'après le where
        $partenaireExiste->bindParam(':nom', $nom, PDO::PARAM_STR);
        $partenaireExiste->bindParam(':letype', $type, PDO::PARAM_STR); // je met letype pur éviter des colision avec d'éventuel fonction type ou autre
        $partenaireExiste->bindParam(':idref', $idref, PDO::PARAM_STR);
        $partenaireExiste->execute();
        foreach ($partenaireExiste as $id) {
            $idpartenaire = $id;
        }
        if (!isset($idpartenaire)) {
            $idpartenaire = 1;
            $rechercheidpartenaire = $cnx->prepare("SELECT MAX(id) FROM `partenaires`;");
            $rechercheidpartenaire->execute();
            foreach ($rechercheidpartenaire as $id) {
                $idpartenaire = $id["MAX(id)"]+1;
            }
            $sth = $cnx->prepare('INSERT INTO `partenaires` (`id`, `nom`, `letype`, `idref`) VALUES (:idpartenaire, :nom, :letype, :idref)');
            $sth->bindParam(':idpartenaire', $idpartenaire, PDO::PARAM_INT);
            $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
            $sth->bindParam(':letype', $type, PDO::PARAM_STR);
            $sth->bindParam(':idref', $idref, PDO::PARAM_STR);
            $sth->execute();
        }
        $sth = $cnx->prepare("INSERT INTO `soutiens` (`idPartenaire`, `idThese`) VALUES (:idpartenaire, :idThese)");
        $sth->bindParam(':idpartenaire', $idpartenaire, PDO::PARAM_INT);
        $sth->bindParam(':idThese', $idThese, PDO::PARAM_INT);
        $sth->execute();
    }
}


?>