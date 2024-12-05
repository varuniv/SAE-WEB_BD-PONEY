<?php
// Load du header des pages (Non fait encore)
$loginInputs=array(
    "email" =>[
        "type" => "text",
        "required" => true
    ],
    "password"=>[
        "type" => "text",
        "name" => "password",
        "required" => true
    ]
)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Grand Galop: Login</title>
</head>
<body>
    <?php
    ?>
    <div class="main">
        <img src="img/loginImg.png" alt="Image de la page de connexion">
        <div class="aside">
            <img src="img/loginTitle.png" alt="Titre:Grand Galop">
            <form action="login.php" method="POST">
                <?php
                echo '<label class="loginLab">Adresse e-mail</label>';
                echo '<input class="loginInputs" type="'.$loginInputs["email"].'">';
                echo '<label class="loginLab">Mot de passe</label>';
                echo '<input class="loginInputs" type="'.$loginInputs["password"].'">';
                ?>
                <div class="submit-btn">
                    <input id="connect" type="submit" value="Se connecter">
                    <input type="button" value="S'inscrire">
                </div>
            </form>
        </div>
    </div>
</body>
</html>