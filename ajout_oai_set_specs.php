<?php
   function ajout_oai_set_specs($oai_set_specs, $cnx, $idThese) {
    foreach ($oai_set_specs as $oai_set_spec)
        $sth = $cnx->prepare('INSERT INTO `oai_set_specs` (`idThese`, `code`) VALUES (:idThese, :code)');
        $sth->bindParam(':code', $oai_set_spec, PDO::PARAM_STR);
        $sth->bindParam(':idThese', $idThese, PDO::PARAM_INT);
        $sth->execute();
   }
