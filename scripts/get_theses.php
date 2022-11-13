<?php
session_start();
 //initialisation des variable

function get_these($cnx) {
    if (isset($_SESSION["login"])){ 
        echo 'ihr';
        $request ="SELECT DISTINCT theses.id, theses.etablissements_soutenance";
        if ((isset($_POST["nom"]) && $_POST["nom"]!="")||isset($_POST["prenom"]) && $_POST["prenom"]!="") {
            $request .= ", personnes.nom, personnes.prenom ";
        }
        
        if (isset($_POST["titre"]) && $_POST["titre"]!="") {
            $request .= ", titres.titre ";
        }
        $request .= "FROM theses";
        /*
        if (isset($_POST["nom"])) {
            $personneNom = $cnx->prepare("SELECT id FROM personnes WHERE nom=:nom");        
            $personneNom->bindParam(':nom', $_POST["nom"], PDO::PARAM_STR);
        }*/
        /*
        if (isset($_POST["prenom"])) {
            $personnePrenom = $cnx->prepare("SELECT id FROM personnes WHERE prenom=:prenom");        
            $personnePrenom->bindParam(':prenom', $_POST["prenom"], PDO::PARAM_STR);
        }*/
        /*
        if (isset($_POST["titre"])) {
            $personnePrenom = $cnx->prepare("SELECT * FROM these WHERE titre LIKE '%:titre%'");        
            $personnePrenom->bindParam(':titre', $_POST["titre"], PDO::PARAM_STR);
        }*/
        if ((isset($_POST["nom"]) && $_POST["nom"]!="")||(isset($_POST["prenom"]) && $_POST["prenom"]!="")||(isset($_POST["titre"]) && $_POST["titre"]!="")) {
            $request .= ", titres, personnes, auteurs WHERE
            (auteurs.idPersonne = personnes.id AND auteurs.idThese = theses.id)
            ";
        }
        if (isset($_POST["nom"]) && $_POST["nom"]!="") {
            echo ("nom");
            $request .= " AND personnes.nom = :nom";
        }
        if (isset($_POST["prenom"]) && $_POST["prenom"]!="") {
            echo ("prenom");
            $request .= " AND personnes.prenom = :prenom";
        }
        if (isset($_POST["titre"]) && $_POST["titre"]!="") {
            echo ("titre");
            $titre = "%".$_POST["titre"]."%";
            $request .= " AND titres.titre LIKE :titre AND titres.idThese = theses.id";
        }
        $theses = $cnx->prepare($request);
        if (isset($_POST["prenom"]) && $_POST["prenom"]!="") {
            echo ("prenom");
            $theses->bindParam(':prenom', $_POST["prenom"], PDO::PARAM_STR);  
        } 
        if (isset($_POST["nom"]) && $_POST["nom"]!="") {
            echo ("nom");
            $theses->bindParam(':nom', $_POST["nom"], PDO::PARAM_STR);  
        }
        if (isset($_POST["titre"]) && $_POST["titre"]!="") {
            echo ("titre");
            $theses->bindParam(':titre', $titre, PDO::PARAM_STR);  
        }
        $theses->debugDumpParams();
        $theses->execute();
        print_r($theses->errorInfo());
        return $theses->fetchAll();
    }
}


?>