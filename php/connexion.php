<?php
session_start();
include_once "config.php";
$email = $_POST["email"];
$pass = $_POST["pass"];
if (!empty($email) && !empty($pass)) {
    //verifions si le user a rentrer un email et un mdp qu'on a dans la db
    $sql = "SELECT * FROM users WHERE email=:email AND pass=:pass";
    $requete = $db->prepare($sql);
    $requete->bindValue(":email", $email, PDO::PARAM_STR);
    $requete->bindValue(":pass", $pass, PDO::PARAM_STR);
    $requete->execute();
    $count = $requete->rowCount();
    if ($count > 0) { //si les donnés de l'utilisateurs correspondent
        $row = $requete->fetch();
        //si le user se reconnecte on active aussi son statut en ligne
        $status = "En Ligne";
        $sql2 = "UPDATE users SET status =:status WHERE unique_id =:unique_id";
        $requete2 = $db->prepare($sql2);
        $requete2->bindValue(":status", $status);
        $requete2->bindValue(":unique_id", $row["unique_id"]);
        $requete2->execute();
        if ($sql2) {
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        }
    } else {
        echo "L'email et / ou le mot de passe sont incorrecte";
    }
} else {
    echo "Tout les champs sont requis";
}