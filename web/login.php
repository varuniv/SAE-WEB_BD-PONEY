<?php

session_start();

require_once("../bd/connexion.php");

if (isset($_POST['connect'])) {
    
    $email = $_POST["email"];
    $password = $_POST["password"];


    function getPersonneByEmail($email, $connexion) {
        $sql = "SELECT * FROM PERSONNE WHERE mail = :email";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    $connexion = connexionBd();

    if ($connexion) {
        
        $personne = getPersonneByEmail($email, $connexion);

        if ($personne) {
            
            $id = $personne["id"];
            if ($password == $id) {
                
                $_SESSION["user_id"] = $id;
                $_SESSION["email"] = $email;
                $_SESSION["prenom"] = $personne["prenom"];
                $_SESSION["nom"] = $personne["nom"];
                
                if ($id > 100){
                    header("Location: accueil_moniteur.php");
                    exit();
                } else {
                    header("Location: accueil.php");
                exit();
                }
                
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet email.";
        }
    } else {
        echo "Erreur de connexion à la base de données.";
    }
}


?>

<!DOCTYPE html>
<html lang="en" style="height:100%">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/login.css">
    <title>Grand Galop</title>
</head>
<body class="h-100">
    <div class="login_div">
        <img src="img/poneyAccueil.png" alt="Image de la page de connexion">
        <div class="aside">
            <img src="img/loginTitle.png" alt="Titre:Grand Galop">
            <form action="login.php" method="POST">
                <label class="loginLab">Email</label>
                <input class="loginInputs" type="text" name="email" required>

                <label class="loginLab">Mot de passe (ID)</label>
                <input class="loginInputs" type="password" name="password" required>

                <div class="submit-btn">
                    <input id="connect" name="connect" type="submit" value="Se connecter">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
