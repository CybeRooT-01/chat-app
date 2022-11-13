<?php
session_start();
if (!isset($_SESSION["unique_id"])) { //si le mec n'est pas connecté et vexu acceder a la page profil, 
    header("location: connexion.php"); //on l'envoie a connexion.php
}
?>
<?php
include_once("php/header.php");
?>

<body>
    <div class="wrapper">
        <section class="chat">
            <header>
                <?php
                include_once("php/config.php");
                //$unique = $_SESSION["unique_id"];
                $user_id = $_GET["user_id"];
                $sql = "SELECT * FROM users WHERE unique_id =:user_id";
                $requete = $db->prepare($sql);
                $requete->bindValue(":user_id", $user_id);
                $requete->execute();
                $count = $requete->rowCount();
                if ($count > 0) {
                    $row = $requete->fetch();
                }
                ?>
                <a href="profil.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row["img"]
                                        ?>" draggable="false">
                <div class="details">
                    <span><?php echo $row["nom"] . " " . $row["prenom"]
                            ?></span>
                    <p><?php echo $row["status"]
                        ?></p>
                </div>
            </header>
            <div class="chat-box">

            </div>
            <form action="#" class="saisie" autocomplete="off">
                <input type="text" name="id_sortant" value="<?= $_SESSION["unique_id"] ?>" hidden>
                <input type="text" name="id_entrant" value="<?= $user_id ?>" hidden>
                <input type="text" name="message" class="champ_saisie" placeholder="Message">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <script src="js/discussion.js"></script>
</body>

</html>