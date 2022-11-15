<?php 
function get_index_these($cnx) {
    $rechercheidthese = $cnx->prepare("SELECT MAX(id) FROM `theses`;");
    $rechercheidthese->execute();
    foreach ($rechercheidthese as $id) {
        $idThese = $id["MAX(id)"];
    }
    if (!isset($idThese)) {
        $idThese = 0;
    }
    return $idThese;
}
?>