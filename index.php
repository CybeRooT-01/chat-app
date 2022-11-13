<?php
session_start();
// si le user se reconnecte dans le meme navigateur(donc son session est active) on l'envoie dans la page de profil
if (isset($_SESSION["unique_id"])) {
    header("location: profil.php");
}
?>
<?php include_once("php/header.php"); ?>

<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Chat App</header>
            <form action="#" enctype="multipart/form-data" autocomplete="off">
                <div class="error_zone"></div>
                <div class="name-details">
                    <div class="field input">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" placeholder="nom" required>
                    </div>
                    <div class="field input">
                        <label for="prenom">prenom</label>
                        <input type="text" name="prenom" placeholder="prenom" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Votre address Email" required>
                </div>
                <div class="field input">
                    <label for="">Mot de passe</label>
                    <input type="password" name="pass" placeholder="Mot de passe" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field image">
                    <label for="">Choisissez une image</label>
                    <input type="file" name="image">
                </div>
                <div class="field button">
                    <input type="submit" value="S'inscrire">
                </div>
            </form>
            <div class="link">Deja membre ? <a href="connexion.php">Se connecter</a></div>
        </section>
    </div>
    <script src="js/afficher-cacher-mdp.js"></script>
    <script src="js/inscription.js"></script>
</body>

</html>