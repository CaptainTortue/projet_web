<?php

function addAlertUser($cnx, $params, $user) {
    if (isset($_SESSION["login"])) {
        $request = "INSERT INTO `alert` (`id`, `titre`, `address`, `filtreType`, `filtreNom`, `filtrePrenom`, `filtreTitre`, `filtreDiscipline`, `user`)
                    VALUES (NULL, :titreAlert, :address, :filtreType, :filtreNom, :filtrePrenom, :filtreTitre, :filtreDiscipline, :user)";
    }
    $alerts = $cnx->prepare($request);

    if (isset($params["nom"]) && $params["nom"]!="") {
        $type = $params["type"];
        $nom = $params["nom"];
    } else {
        $type = null;
        $nom = null;
    }
    if (isset($params["prenom"]) && $params["prenom"]!="") {
        $type = $params["type"];
        $prenom = $params["prenom"];
    } else {
        $prenom = null;
    }
    if (isset($params["titre"]) && $params["titre"]!="") {
        $titre = $params["titre"];
    } else {
        $titre = null;
    }
    if (isset($params["discipline"]) && $params["discipline"]!="") {
        $discipline = $params["discipline"];
    } else {
        $discipline = null;
    }
    $titreAlert = $params["titreAlert"];
    $addressAlert = $params["addressAlert"];

    $alerts->bindParam(':user', $user, PDO::PARAM_INT);
    $alerts->bindParam(':titreAlert', $titreAlert, PDO::PARAM_STR);
    $alerts->bindParam(':address', $addressAlert, PDO::PARAM_STR);
    $alerts->bindParam(':filtreType', $type, PDO::PARAM_STR);
    $alerts->bindParam(':filtreNom', $nom, PDO::PARAM_STR);
    $alerts->bindParam(':filtrePrenom', $prenom, PDO::PARAM_STR);
    $alerts->bindParam(':filtreTitre', $titre, PDO::PARAM_STR);
    $alerts->bindParam(':filtreDiscipline', $discipline, PDO::PARAM_STR);
    if ($alerts->execute()){
        return true;
    }
    return false;

}
?>