<?php
session_start();
include_once "config.php";
$id_sortant = $_SESSION["unique_id"];
$sql = "SELECT * FROM users WHERE NOT unique_id =:id_sortant"; //selectionne les gens a afficher (en retirant le proprio du compte...)
$requete = $db->prepare($sql);
$requete->bindValue("id_sortant", $id_sortant);
$requete->execute();
$count = $requete->rowCount();
$ami = "";
if ($count == 0) { //s'il ya une seule ligne dans la bd(ce qui veut dire que c'est nous)
    $ami .= "Il n'y a personne avec qui vous pouvez discuter";
} elseif ($count > 0) {
    while ($row = $requete->fetch()) {
        $sql2 = "SELECT * FROM messages WHERE (id_sms_entrant =:unique_id 
        OR id_sms_sortant =:unique_id)AND (id_sms_sortant =:id_sortant 
        OR id_sms_entrant =:id_sortant) ORDER BY message_id DESC LIMIT 1"; //requete pour afficher le message en dessus du profil
        $requete2 = $db->prepare($sql2);
        $requete2->bindValue(":unique_id", $row["unique_id"]);
        $requete2->bindValue(":id_sortant", $id_sortant);
        $requete2->execute();
        $count2 = $requete2->rowCount();
        $row2 = $requete2->fetch();
        if ($count2 > 0) {
            $resultat = $row2["sms"];
        } else {
            $resultat = "Pas de message ";
        }
        //si le message depasse 28 caractere on met les le reste en ...
        (strlen($resultat) > 28) ? $sms = substr($resultat, 0, 28) . '...'  : $sms = $resultat;

        //detail pour montrer qui a envoyer le dernier message comme sur whatspp... il gueulais trop dnc j'ai mis un @ pour le calmer
        @($id_sortant == $row2["id_sms_entrant"]) ? $vous = "Vous: " : $vous = "";

        //si le user est en ligne ou pas
        ($row["status"] == "Hors Ligne") ? $offline = "offline" : $offline = "";

        $ami .= '<a href="discussion.php?user_id=' . $row["unique_id"] . '">
                    <div class="content">
                        <img src="php/images/' . $row["img"] . ' " draggable="false">
                        <div class="details">
                            <span>' . $row["nom"] . " " . $row["prenom"] . '</span>
                            <p>' . $vous . $sms . '</p>
                        </div>
                    </div>
                    <div class="en-ligne ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
    }
}
echo $ami;