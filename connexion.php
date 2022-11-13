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
        <section class="form login">
            <header>Chat App</header>
            <form action="#">
                <div class="error_zone">this is an error example</div>
                <div class="name-details">
                </div>
                <div class="field input">
                    <label for="prenom">Email</label>
                    <input type="text" name="email" placeholder="Votre address Email">
                </div>
                <div class="field input">
                    <label for="">Mot de passe</label>
                    <input type="password" name="pass" placeholder="Mot de passe">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="Se connecter">
                </div>
            </form>
            <div class="link">Pas encore inscrit ? <a href="index.php">S'inscrire</a></div>
        </section>
    </div>
    <script src=" js/afficher-cacher-mdp.js"></script>
    <script src=" js/connexion.js"></script>
</body>

</html>