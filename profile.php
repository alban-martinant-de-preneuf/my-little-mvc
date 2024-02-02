<?php

use App\Controller\AthenticationController;

require_once 'vendor/autoload.php';

$auth = new AthenticationController();

if (isset($_POST['session_destroy'])) {
    session_destroy();
    header('Location: /my-little-mvc/login.php');
}

if (isset($_POST['update_profile'])) {
    try {
        $auth->updateProfile($_POST['email'], $_POST['fullname']);
        $updateMessage = 'Profil modifié';
    } catch (\Exception $e) {
        $updateMessage = $e->getMessage();
    }
}

if (!$auth->profile()) {
    header("refresh:2;url=login.php");
} else {
    $user = unserialize($_SESSION['user']);
}

if (isset($_POST['update_pwd'])) {
    try {
        $auth->updatePassword($_POST['password'], $_POST['passwordConfirm']);
        $pwdMessage = 'Mot de passe modifié';
    } catch (\Exception $e) {
        $pwdMessage = $e->getMessage();
    }
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
        <p>Bonjour <?= $user->getFullname() ?></p>
        <p>Votre email est <?= $user->getEmail() ?></p>
        <p>Vous êtes
            <?php $firstLoop = true ?>
            <?php foreach ($user->getRole() as $role) : ?>
                <?php if (!$firstLoop) {
                    echo ', ';
                } else {
                    $firstLoop = false;
                }
                ?>
                <?= $role ?>
            <?php endforeach; ?>
        </p>

        <form action="" method="post">
            <input type="submit" name="session_destroy" value="Se déconnecter">
        </form>

        <h3>Modifier vos informations</h3>
        <?php if (isset($updateMessage)) : ?>
            <p><?= $updateMessage ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $user->getEmail() ?>" required>
            <label for="fullname">Nom complet</label>
            <input type="text" name="fullname" id="fullname" value="<?= $user->getFullname() ?>" required>
            <input type="submit" name="update_profile" value="Modifier">
        </form>
        <h3>Modifier votre mot de passe</h3>
        <?php if (isset($pwdMessage)) : ?>
            <p><?= $pwdMessage ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" id="password" required>
            <label for="passwordConfirm">Confirmer le nouveau mot de passe</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm" required>
            <input type="submit" name="update_pwd" value="Modifier">
        </form>
    <?php else : ?>
        <p>Vous devez vous connecter pour accéder à votre profil</p>
    <?php endif; ?>
</body>

</html>