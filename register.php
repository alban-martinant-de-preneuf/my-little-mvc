<?php

use App\Controller\AthenticationController;

require_once 'vendor/autoload.php';

$message = 'Inscrivez-vous';

if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password'])) {
    $auth = new AthenticationController();
    try {
        $auth->register($_POST['email'], $_POST['password'], $_POST['fullname']);
        $message = 'Inscription réussie';
    } catch (\Exception $e) {
        $message = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    
    <h1>Inscription</h1>
    <?= "<p>" . $message . "</p>" ?>
    <form action="" method="post">
        <label for="fullname">Nom complet</label>
        <input type="text" name="fullname" id="fullname" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="S'inscrire">
    </form>

</body>
</html>