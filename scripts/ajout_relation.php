<?php
    function ajout_relation($personnes, $idThese, $cnx, $table) {
        $idref = NULL;
        foreach ($personnes as $personne) {
            if (isset($personne["nom"])) {
                $nom = $personne["nom"];
            }
            if (isset($personne["prenom"])) {
                $prenom = $personne["prenom"];
            }
            $resultIdPersonne = $cnx->prepare("SELECT id FROM `personnes` WHERE nom=:nom AND prenom=:prenom;");
            $resultIdPersonne->bindParam(':nom', $nom, PDO::PARAM_STR);
            $resultIdPersonne->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $resultIdPersonne->execute();
            foreach ($resultIdPersonne as $id) {
                $idPersonne = $id['id'];
                echo 'personne   '.$idPersonne."<br/>";
            }
            
            echo "personne".$idPersonne."et these".$idThese."<br/>";



            if (isset($idPersonne)) {
                $sth = $cnx->prepare("INSERT INTO `$table` (`idPersonne`, `idThese`) VALUES (:idPersonne, :idThese)");
                // bind param marche pas sur le nom d'une table (surement parce qu'un str en sous ' et pas `), de plus il est moins utile car non modifiable par l'utilisateur
                $sth->bindParam(':idPersonne', $idPersonne, PDO::PARAM_INT);
                $sth->bindParam(':idThese', $idThese, PDO::PARAM_INT);
                $sth->execute();
            }
        }
    }
?>