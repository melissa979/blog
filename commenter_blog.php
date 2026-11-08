<?php
/**
 * commenter_blog.php - Ajoute un commentaire à un billet (aucun template : n'affiche rien).
 * Paramètres POST : ID (billet), comment (contenu), nom (auteur).
 * Auteur : SALHI Melissa
 */
require_once 'config_blog.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index_blog.php');
    exit;
}

// 1) L'identifiant doit être correct et correspondre à un billet existant
$id = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: index_blog.php');
    exit;
}
$req = $pdo->prepare('SELECT COUNT(*) FROM billets_blog WHERE ID = ?');
$req->execute([$id]);
if ((int) $req->fetchColumn() === 0) {
    header('Location: index_blog.php');
    exit;
}

// 2) Nettoyage du nom et du commentaire
$nom     = mb_substr(trim($_POST['nom'] ?? ''), 0, 50);
$comment = trim($_POST['comment'] ?? '');

// 3) Insertion (date_comment est un TIMESTAMP rempli automatiquement)
if ($nom !== '' && $comment !== '') {
    $req = $pdo->prepare('INSERT INTO commentaires_blog (nom, comment, ID) VALUES (?, ?, ?)');
    $req->execute([$nom, $comment, $id]);
}

// 4) Retour sur le billet
header('Location: afficher_blog.php?ID=' . $id);
exit;
