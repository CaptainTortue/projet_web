<?php 

    function ajout_sujets($idThese, $cnx, $sujets)
    {        
        foreach ($sujets as $sujet) {
            ajout_texte("sujet", $idThese, $cnx, $sujet);
        }
    }


?>