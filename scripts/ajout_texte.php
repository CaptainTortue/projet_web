<?php 

    function ajout_texte($type, $idThese, $cnx, $contenue)
    {        
        $table = $type."s";
        //echo "INSERT INTO `$table` (`idThese`, `langue`, `$type`) VALUES (:idThese, :langue, :contenue)";
            $sth = $cnx->prepare("INSERT INTO `$table` (`idThese`, `langue`, `$type`) VALUES (:idThese, 'fr', :contenue)");
            // bind param marche pas sur le nom d'une table (surement parce qu'un str en sous ' et pas `), de plus il est moins utile car non modifiable par l'utilisateur
            $sth->bindParam(':idThese', $idThese, PDO::PARAM_INT);
            $sth->bindParam(':contenue', $contenue, PDO::PARAM_STR);
            $sth->execute();
    }


?>