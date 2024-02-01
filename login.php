<?php

use App\Controller\AthenticationController;

require_once 'vendor/autoload.php';

$message = 'Connectez-vous';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $auth = new AthenticationController();
    try {
        $auth->login($_POST['email'], $_POST['password']);
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
    <title>Connexion</title>
</head>
<body>
    
    <h1>Connection</h1>
    <?= "<p>" . $message . "</p>" ?>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Se connecter">
    </form>

</body>
</html>