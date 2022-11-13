<?php
session_start();
if (isset($_SESSION["unique_id"])) {
    include_once("config.php");
    $id_sortant = $_POST["id_sortant"];
    $id_entrant = $_POST["id_entrant"];
    $resultat = "";
    function neRienFaire()
    {
        //Rien a l'interieur mdrrrr :-) 
    }
    $sql = "SELECT * FROM messages m
    LEFT JOIN users u ON u.unique_id = m.id_sms_entrant
    WHERE(id_sms_sortant=$id_sortant AND id_sms_entrant=$id_entrant)
    OR (id_sms_sortant=$id_entrant AND id_sms_entrant=$id_sortant) ORDER BY message_id ";
    $requete = $db->query($sql);
    $count = $requete->rowCount();
    if ($count > 0) {
        while ($row = $requete->fetch()) {
            if ($row["id_sms_sortant"] != $id_sortant) { //alors c'est un envoie
                $resultat .= ' <div class="message entrant  ">
                                    
                                    <div class="details">
                                        <p>' . $row["sms"] . '</p>
                                    </div>
                                </div>';
            } else { //c'est une reception de message
                $resultat .= '<div class="message  sortant">
                                <img src="php/images/' . $row["img"] . ' " draggable="false" height="40" width="40">
                                    <div class="details">
                                    <p>' . $row["sms"] . '</p>
                                </div>
                             </div>';
            }
        }
        echo $resultat;
    }
} else {
    header("../connexion.php");
}