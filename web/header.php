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
        <nav>
            <div style="display: flex;background-color: black;position: fixed;width: 100%;padding: 1rem 20px;">
                <button style="padding: 10px;background-color: #F5DF4D;border-radius: 40%;">
                    <a href="login.php">Accueil</a>
                </button>
            </div>
        </nav>
    </header>