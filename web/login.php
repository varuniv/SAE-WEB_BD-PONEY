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