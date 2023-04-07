<?php
function getAlertUser($cnx, $user) {
    if (isset($_SESSION["login"])) {
        $request = "SELECT alert.* FROM alert JOIN users on alert.user = users.id WHERE alert.user = :user;";
    }
    $alerts = $cnx->prepare($request);
    $alerts->bindParam(':user', $user, PDO::PARAM_INT);
    $alerts->execute();
    return $alerts->fetchAll();

}
?>
