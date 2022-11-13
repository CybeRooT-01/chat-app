<?php
session_start();
if (isset($_SESSION["unique_id"])) {
    include_once("config.php");
    $id_sortant = $_POST["id_sortant"];
    $id_entrant = $_POST["id_entrant"];
    $message = $_POST["message"];
    if (!empty($message)) {
        $sql = "INSERT INTO messages (id_sms_entrant, id_sms_sortant, sms) VALUES
        (:id_sortant, :id_entrant, :message)" or die();
        $requete = $db->prepare($sql);
        $requete->bindValue(":id_sortant", $id_sortant);
        $requete->bindValue(":id_entrant", $id_entrant);
        $requete->bindValue(":message", $message);
        $requete->execute();
    }
} else {
    header("../connexion.php");
}