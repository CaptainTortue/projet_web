<!DOCTYPE html>
<?php
    session_start();
    // Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/acueil.css">

    <?php
        include("../../include/connexion.inc.php");
        include("../../scripts/getAlertUser.php");
        include("../../scripts/getTheses.php");
        include("../../scripts/addAlertUser.php");

        /*// Include library files
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';*/

        require_once "../../vendor/autoload.php";

        // check if hard refresh for chrome, refersh for the rest (aparently)
        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

        if ($pageWasRefreshed && $_SERVER['REQUEST_METHOD'] == 'POST' && ((isset($_POST["nom"]) && $_POST["nom"] != null) || (isset($_POST["prenom"]) && $_POST["prenom"] != null) || (isset($_POST["titre"]) && $_POST["titre"] != null) || (isset($_POST["discipline"]) && $_POST["discipline"] != null))) {
            $resultAdd = addAlertUser($cnx, $_POST, $_SESSION["idUser"]);
            if ($resultAdd) {
                /*echo "envoie email";
                $body = "";
                $theses = get_these($cnx);
                if (isset($theses)) {
                    foreach ($theses as $these) {
                        if (isset($these["titre"])) {
                            $body .= $these["titre"]." de ".$these["nom"]." ".$these["prenom"]."\\n";
                        }
                    }
                }
                $body = str_replace($body, "'", '"');*/
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.courier.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "message": {
                            "to": {
                                "email": "'.$_POST["addressAlert"].'"
                            },
                            "content": {
                                "title":"Vous avez bien créer votre nouvel alert",
                                "body":"Votre alert '.$_POST["titreAlert"].' a bien été créer"
                            }
                        }
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer dk_prod_37FFCXTZ40MMBNPBTAD1GVWXNS1R',
                        'Content-Type: text/plain'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
            } else {
                echo "problème";
            }
        }

        $alerts = getAlertUser($cnx, $_SESSION["idUser"]);
    ?>
</head>

<body>
    <h1 class="titre">Gestions de vos alert</h1>

    <form action="alert.php" method="POST">
        <div class="group_form">
            <div class="computer_flex wrap">
                <div class="element_form computer_flex">
                    <b>Type de personne: </b>
                    <select name="type" id="type">
                        <option value="auteurs">Auteur</option>
                        <option value="directeurs">Directeur</option>
                        <option value="rapporters">Rapporter</option>
                    </select>
                </div>
                <div class="element_form">
                    <b>Nom: </b> <input type="text" name="nom"/>
                </div>
                <div class="element_form">
                    <b>Prenom: </b> <input type="text" name="prenom"/>
                </div>
                <div class="element_form">
                    <b>Titre: </b><input type="text" name="titre"/>
                </div>
                <div class="element_form">
                    <b>Discipline: </b><input type="text" name="discipline"/>
                </div>
            </div>
            <div class="computer_flex">
                <div class="element_form">
                    <b>Titre de votre alert: </b><input type="text" name="titreAlert" required/>
                    <b>Adresse d'expédition: </b><input type="text" name="addressAlert" required placeholder="test.test@gmail.com"/>
                </div>
            </div>
            <input type="reset" name="reset" value="Effacez"/> <input type="submit" name="submit" value="Ajouter une alerte"/>
        </form>
        </div>

    <?php

        if (isset($alerts)) {
            echo '<div class="accordion" id="alerts">';
            $id = 0;
            foreach($alerts as $alert) {
                echo
                    '<div class="accordion-item" style="border-width: 4px; border-color: black;">
                        <h2 class="accordion-header" id="heading'.$id.'">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$id.'" aria-expanded="true" aria-controls="collapse'.$id.'">
                            '.$alert["titre"].'
                        </button>
                        </h2>
                        <div id="collapse'.$id.'" class="accordion-collapse collapse" aria-labelledby="heading'.$id.'" data-bs-parent="#these">
                        <div class="accordion-body">';
                if (isset($alert["filtreType"])) {
                    echo "<div class='computer_flex'> <h5>Par ".$alert["filtreType"]." </h5>";
                    echo "<p>";
                    if (isset($alert["filtreNom"])) {
                        echo $alert["filtreNom"];
                    }
                    if (isset($alert["filtrePrenom"])) {
                        echo $alert["filtrePrenom"];
                    }
                    echo '</p></div>';
                }
                if (isset($alert["filtreTitre"])) {
                    echo "<div class='computer_flex'><h5>Par titre: </h5><p>".$alert["filtreTitre"]."</p></div>";
                }
                if (isset($alert["filtreDiscipline"])) {
                    echo "<div class='computer_flex'><h5>Par discipline: </h5><p>".$alert["filtreDiscipline"]."</p></div>";
                }
                echo '</div>
                        </div>
                    </div>';
                $id += 1;

            }
        }
    ?>
</body>
