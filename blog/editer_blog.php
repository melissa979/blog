<?php
/**
 * editer_blog.php - Ajoute un billet.
 * Mode 1 : pas de données POST -> affiche le formulaire.
 * Mode 2 : données POST -> nettoie, enregistre, redirige vers le billet.
 * Auteur : SALHI Melissa
 */
require_once 'config_blog.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['titre'], $_POST['contenu'], $_POST['categorie'])) {

    // Nettoyage des entrées (longueurs = tailles des colonnes)
    $titre     = mb_substr(trim($_POST['titre']), 0, 120);
    $contenu   = trim($_POST['contenu']);
    $categorie = mb_substr(trim($_POST['categorie']), 0, 12);

    if ($titre === '' || $contenu === '' || $categorie === '') {
        exit('Tous les champs sont obligatoires. <a href="editer_blog.php">Retour</a>');
    }

    // Annonce : extrait du billet sans balises (TINYTEXT = 255 octets max)
    $annonce = mb_strcut(strip_tags($contenu), 0, 200, 'UTF-8');
    if (mb_strlen(strip_tags($contenu)) > mb_strlen($annonce)) {
        $annonce .= '...';
    }

    $req = $pdo->prepare(
        'INSERT INTO billets_blog (titre, contenu, annonce, date_billet, categorie)
         VALUES (?, ?, ?, NOW(), ?)'
    );
    $req->execute([$titre, $contenu, $annonce, $categorie]);

    $id = (int) $pdo->lastInsertId();
    header('Location: afficher_blog.php?ID=' . $id);
    exit;
}

$smarty->assign('titre', 'Nouveau billet');
$smarty->display('edition_blog.tpl');
