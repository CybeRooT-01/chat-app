<?php
session_start();
include_once "config.php";
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$email = $_POST["email"];
$pass = $_POST["pass"];
function neRienFaire()
{
    //Rien a l'interieur mdrrrr :-) 
}
if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($pass)) {
    //verifi si l'email de l'utilsiateur est correct
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //verifions si l'email existe deja 
        $sql = "SELECT * FROM users where email =:email";
        $requete = $db->prepare($sql);
        $requete->bindValue(":email", $email, PDO::PARAM_STR);
        $requete->execute();
        $users = $requete->fetch();
        if ($users) { //si le user exist deja
            echo "$email- existe deja";
        } else {
            //verifions si le mec a uploadé
            if (isset($_FILES["image"])) {
                $img_name = $_FILES["image"]["name"]; //le nom de l'image que le user a uploader
                $img_type = $_FILES["image"]["type"]; //le type de ymg que le user a uploader
                $tmp_name = $_FILES["image"]["tmp_name"]; //le temp name pour sauvegarder le fichier

                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode); //ici on a l'extension

                $extensions = ['png', 'jpeg', 'jpg'];
                if (in_array($img_ext, $extensions) === true) {
                    $time = time();
                    //ona  besoin du temps pour s'assurer que tout les uploads auront un nom unique
                    $new_img_name = $time . $img_name;
                    //cree le dossier ou on va sauvegarder nos images
                    if (!file_exists("images")) {
                        mkdir("images");
                    }
                    if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) { //si le upload et le depalcement ont ete bien fait
                        $status = "En Ligne"; //imediatement apres son inscription le mec devient online
                        $random_id = rand(time(), 10000000); //cree un id aleatoir pour le user

                        //ajouter le user dans notre base de donnée
                        $sql2 = "INSERT INTO users(unique_id, nom , prenom, email, pass, img, status)
                        VALUE(:unique_id, :nom, :prenom, :email, :pass, :img, :status)";
                        $requete2 = $db->prepare($sql2); //NTUI
                        //injecte nos variables
                        $requete2->bindValue(":unique_id", $random_id, PDO::PARAM_STR);
                        $requete2->bindValue(":nom", $nom, PDO::PARAM_STR);
                        $requete2->bindValue(":prenom", $prenom, PDO::PARAM_STR);
                        $requete2->bindValue(":email", $email, PDO::PARAM_STR);
                        $requete2->bindValue(":pass", $pass);
                        $requete2->bindValue(":img", $new_img_name, PDO::PARAM_STR);
                        $requete2->bindValue(":status", $status, PDO::PARAM_STR);
                        //execute
                        $requete2->execute();
                        if ($sql2) {
                            $sql3 = "SELECT * FROM users WHERE email = :email";
                            $requete3 = $db->prepare($sql3);
                            $requete3->bindValue(":email", $email, PDO::PARAM_STR);
                            $requete3->execute();
                            $count = $requete3->rowCount();
                            // $usr = $requete3->fetch();
                            // $count = $usr->rowCount();
                            if ($count > 0) {
                                $row = $requete3->fetch();
                                $_SESSION['unique_id'] = $row['unique_id'];
                                echo "success";
                            }
                        } else {
                            echo "Quelque chose s'est mal passé";
                        }
                    }
                } else {
                    echo "Veuillez selectionner une image de type jpg, png ou jpeg";
                }
            } else {
                echo "Veuillez selectionner une image";
            }
        }
    } else {
        echo "$email - n'est pas un mail valide";
    }
} else {
    echo "Tout les champs sont requis";
}