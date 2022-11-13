<?php 
    $rechercheidthese = $cnx->prepare("SELECT MAX(id) FROM `theses`;");
    $rechercheidthese->execute();
    foreach ($rechercheidthese as $id) {
        $idThese = $id["MAX(id)"];
    }
    if (!isset($idThese)) {
        echo "ijiouhhiehrig";
        $idThese = 0;
    }
    echo "these".$idThese;