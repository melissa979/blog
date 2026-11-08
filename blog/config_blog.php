<?php
/**
 * config_blog.php - Connexion MySQL (PDO) + objet Smarty
 * Auteur : SALHI Melissa
 */
require_once 'libs/Smarty.class.php';   // Smarty 4.x placé dans le dossier libs/

// --- Connexion MySQL ---
$hote = 'localhost';
$base = 'blog';
$user = 'root';
$mdp  = '';           // XAMPP : mot de passe vide par défaut

try {
    $pdo = new PDO("mysql:host=$hote;dbname=$base;charset=utf8mb4", $user, $mdp, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    exit('Erreur de connexion à la base de données.');
}

// --- Smarty (templates dans ./templates) ---
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/templates/');
$smarty->setCompileDir(__DIR__ . '/templates_c/');
