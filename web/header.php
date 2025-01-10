<?php
?>

<!doctype html>
<html lang="fr" style="height:100%">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Grand Galop</title>
    <?php
    // Inclure le fichier CSS spécifique à la page
    if (isset($cssFile)) {
        echo '<link rel="stylesheet" href="'.$cssFile.'">';
    } else {
        echo '<link rel="stylesheet" href="styles/accueil.css">';
    }
    ?>
</head>
<body style="margin: 0;height:100%">
    <header>
        <nav class = "navbar border d-flex justify-content-between " style= "background-color:#AF8669">
            <div class="mx-3">
                <a href="accueil.php"><img src="/img/loginTitle.png" alt="Accueil" style="max-height:50px"></a>
            </div>
            <div class="mx-3">
                <a class = "btn rounded-3 border-1 border-dark " style= "background-color:#F5DF4D" href="login.php">Déconnexion</a> 
            </div>
        </nav>
    </header>