<?php

function get_these($cnx) {
    if (isset($_SESSION["login"])){
        $request ="SELECT DISTINCT theses.id, theses.embargo, theses.etablissements_soutenance, theses.date_soutenance, theses.status, theses.discipline, theses.langue, theses.estAccessible, theses.nnt, resumes.resume, titres.titre, personnes.nom, personnes.prenom ";
        if (isset($_POST['type'])) {
            $type = $_POST['type'];
        } else {
            $type = 'auteurs';
        }
        $request .= " FROM theses LEFT JOIN resumes ON theses.id = resumes.idThese LEFT JOIN titres ON theses.id = titres.idThese, personnes, ".$type." WHERE
        (".$type.".idPersonne = personnes.id AND ".$type.".idThese = theses.id) ";

        if (isset($_POST["nom"]) && $_POST["nom"]!="") {
            $nom = "%".$_POST["nom"]."%";
            $request .= " AND personnes.nom LIKE :nom";
        }
        if (isset($_POST["prenom"]) && $_POST["prenom"]!="") {
            $prenom = "%".$_POST["prenom"]."%";
            $request .= " AND personnes.prenom LIKE :prenom";
        }
        if (isset($_POST["titre"]) && $_POST["titre"]!="") {
            $titre = "%".$_POST["titre"]."%";
            $request .= " AND titres.titre LIKE :titre";
        }
        if (isset($_POST["discipline"]) && $_POST["discipline"]!="") {
            $discipline = "%".$_POST["discipline"]."%";
            $request .= " AND theses.discipline LIKE :discipline";
        }
        $theses = $cnx->prepare($request);
        if (isset($_POST["prenom"]) && $_POST["prenom"]!="") {
            $theses->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        }
        if (isset($_POST["nom"]) && $_POST["nom"]!="") {
            $theses->bindParam(':nom', $nom, PDO::PARAM_STR);
        }
        if (isset($_POST["titre"]) && $_POST["titre"]!="") {
            $theses->bindParam(':titre', $titre, PDO::PARAM_STR);
        }
        if (isset($_POST["discipline"]) && $_POST["discipline"]!="") {
            $theses->bindParam(':discipline', $discipline, PDO::PARAM_STR);
        }
        //$theses->debugDumpParams();
        $theses->execute();
        //print_r($theses->errorInfo());
        return $theses->fetchAll();
    }
}


?>