<?php
/**
 * index_blog.php - Liste des billets les plus récents (filtrable par catégorie).
 * Auteur : SALHI Melissa
 */
require_once 'config_blog.php';

// Paramètre optionnel : catégorie
$categorie = isset($_GET['categorie']) ? mb_substr(trim($_GET['categorie']), 0, 12) : '';

if ($categorie !== '') {
    $req = $pdo->prepare(
        'SELECT ID, titre, annonce, categorie, date_billet FROM billets_blog
         WHERE categorie = ? ORDER BY date_billet DESC LIMIT 10'
    );
    $req->execute([$categorie]);
} else {
    $req = $pdo->query(
        'SELECT ID, titre, annonce, categorie, date_billet FROM billets_blog
         ORDER BY date_billet DESC LIMIT 10'
    );
}

$billets = [];
foreach ($req as $b) {
    $b['date'] = date('d/m/Y H:i', strtotime($b['date_billet']));
    $billets[] = $b;
}

$smarty->assign('titre', 'Mon blog');
$smarty->assign('categorie', $categorie);
$smarty->assign('billets', $billets);
$smarty->display('index_blog.tpl');
