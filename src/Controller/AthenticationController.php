<?php

namespace App\Controller;

session_start();

use App\Model\User;

class AthenticationController
{
    public function register(string $email, string $password, string $fullname): void
    {  
        $user = new User();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email non valide');
        }
        // Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre
        if (!filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/']])) {
            throw new \Exception('Mot de passe non valide (8 caractères minimum, une majuscule, une minuscule et un chiffre)');
        }
        if (strlen($fullname) < 3) {
            throw new \Exception('Nom complet non valide');
        }
        if ($user->findOneByEmail($email)) {
            throw new \Exception('Email déjà utilisé');
        }
        
        $user->setRole(['ROLE_USER'])
            ->setEmail($email)
            ->setPassword(password_hash($password, PASSWORD_DEFAULT))
            ->setFullname($fullname)
            ->create();
    }

    public function login(string $email, string $password): void
    {
        $user = new User();
        $user = $user->findOneByEmail($email);
        if (!$user) {
            throw new \Exception('Les identifiants fournis ne correspondent à aucun utilisateur');
        }
        if (!password_verify($password, $user->getPassword())) {
            throw new \Exception('Les identifiants fournis ne correspondent à aucun utilisateur');
        }
        $_SESSION['user'] = serialize($user);
        header('Location: /my-little-mvc/shop.php');
    }

    public function profile(): bool
    {
        return isset($_SESSION['user']) ? true : false;
    }

    public function updateProfile(string $email, string $fullname): void
    {
        $user = unserialize($_SESSION['user']);
        $user->setEmail($email)
            ->setFullname($fullname)
            ->update();
        $_SESSION['user'] = serialize($user);
    }

    public function updatePassword(string $password, string $confirmPassword): void
    {
        $user = unserialize($_SESSION['user']);
        if ($password !== $confirmPassword) {
            throw new \Exception('Les mots de passe ne correspondent pas');
        }
        // Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre
        if (!filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/']])) {
            throw new \Exception('Mot de passe non valide (8 caractères minimum, une majuscule, une minuscule et un chiffre)');
        }
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT))
            ->update();
        $_SESSION['user'] = serialize($user);
    }
}