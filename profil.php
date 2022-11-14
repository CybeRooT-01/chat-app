<?php
session_start();
if (!isset($_SESSION["unique_id"])) { //si le mec n'est pas connecté et vexu acceder a la page profil, 
    header("location: connexion.php"); //on l'envoie a connexion.php
}
?>

<?php include_once("php/header.php"); ?>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php
                include_once("php/config.php");
                $unique = $_SESSION["unique_id"];
                $sql = "SELECT * FROM users WHERE unique_id =:unique_id";
                $requete = $db->prepare($sql);
                $requete->bindValue(":unique_id", $unique);
                $requete->execute();
                $count = $requete->rowCount();
                if ($count > 0) {
                    $row = $requete->fetch();
                }
                ?>
                <div class="content">
                    <img src="php/images/<?php echo $row["img"] ?>" draggable="false">
                    <div class="details">
                        <span><?php echo $row["nom"] . " " . $row["prenom"] ?></span>
                        <p><?php echo $row["status"] ?></p>
                    </div>
                </div>
                <a href="php/deconnexion.php?deco_id=<?= $row["unique_id"] ?>" class="logout">Se deconnecter</a>
            </header>
            <div class="search">
                <span class="text">Choisissez un utilisateur pour entammer la connversation</span>
                <input type="text" placeholder="Entre le nom à rechercher...">
                <button> <i class="fas fa-search"></i></button>
            </div>
            <div class="user_list">

            </div>
        </section>
    </div>
    <script src="js/profil.js"></script>
</body>

</html>