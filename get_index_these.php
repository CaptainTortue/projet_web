<?php 
    $rechercheidthese = $cnx->prepare("SELECT MAX(id) FROM `theses`;");
    $rechercheidthese->execute();
    foreach ($rechercheidthese as $id) {
        $idThese = $id["MAX(id)"];
    }
    echo "these".$idThese;