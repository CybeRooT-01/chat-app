<?php
session_start();
include_once "config.php";
$recherche = $_POST["recherche"];
$resultatDeRecherche = "";
$id_sortant = $_SESSION["unique_id"];
$sql = "SELECT * FROM users WHERE NOT unique_id =$id_sortant 
AND (nom like '%$recherche%' OR prenom like '%$recherche%') "; //on enleve aussi le nom du user sur la rechcerche sinon il sera invisible mais visible lors des recherches
$requete = $db->query($sql);
$count = $requete->rowCount();
if ($count > 0) {
    while ($row = $requete->fetch()) {

        $resultatDeRecherche .= '<a href="discussion.php?user_id=' . $row["unique_id"] . '">
                    <div class="content">
                        <img src="php/images/' . $row["img"] . ' " draggable="false">
                        <div class="details">
                            <span>' . $row["nom"] . " " . $row["prenom"] . '</span>
                            <p>This is test sms</p>
                        </div>
                    </div>
                    <div class="en-ligne"><i class="fas fa-circle"></i></div>
                </a>';
    }
} else {
    $resultatDeRecherche .= "Aucun utilisateur trouvé";
}
echo $resultatDeRecherche;