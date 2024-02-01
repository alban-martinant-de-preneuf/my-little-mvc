<?php

use App\Controller\AthenticationController;

require_once 'vendor/autoload.php';

$auth = new AthenticationController();

if (!$auth->profile()) {
    header("refresh:2;url=login.php");
} else {
    $user = $_SESSION['user'];
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>

<body>
    <?php if (isset($user)) : ?>
        <h1>Profil</h1>
        <p>Bonjour <?= $user['fullname'] ?></p>
        <p>Votre email est <?= $user['email'] ?></p>
        <p>Vous êtes
            <?php $firstLoop = true ?>
            <?php foreach ($user['role'] as $role) : ?>
                <?php if (!$firstLoop) {
                    echo ', ';
                } else {
                    $firstLoop = false;
                }
                ?>
                <?= $role ?>
            <?php endforeach; ?>
        </p>
    <?php else : ?>
        <p>Vous devez vous connecter pour accéder à votre profil</p>
    <?php endif; ?>
</body>

</html>