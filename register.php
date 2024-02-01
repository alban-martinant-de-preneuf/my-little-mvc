<?php

namespace App;

require_once 'vendor/autoload.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    
    <form action="" method="post">
        <label for="fullname">Nom complet</label>
        <input type="text" name="fullname" id="fullname" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <label for="password_confirm">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" id="password_confirm" required>
        <input type="submit" value="S'inscrire">
    </form>

</body>
</html>