<?php
session_start();
if (isset($_SESSION["unique_id"])) { //s'il ya une session active dans cette page
    include_once "config.php";
    $deco_id = $_GET["deco_id"]; //recup l'id de deco qu'on avait envoyer en cliquant sur le button deconnecter
    if (isset($deco_id)) {
        $status = "Hors Ligne";
        //on modifie le status de notre base de donnée
        $sql = "UPDATE users SET status =:status WHERE unique_id =$deco_id";
        $requete = $db->prepare($sql);
        $requete->bindValue(":status", $status);
        $requete->execute();
        if ($sql) {
            session_unset();
            session_destroy();
            header("location: ../connexion.php");
        }
    } else {
        header("location: ../profil.php");
    }
} else {
    header("location: ../connexion.php");
}