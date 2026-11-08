<?php
/**
 * afficher_blog.php - Affiche un billet, ses commentaires et le formulaire de commentaire.
 * Auteur : SALHI Melissa
 */
require_once 'config_blog.php';

// Vérification du paramètre ID
$id = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    exit('Identifiant de billet invalide. <a href="index_blog.php">Retour</a>');
}

// Recherche du billet
$req = $pdo->prepare('SELECT ID, titre, contenu, categorie, date_billet FROM billets_blog WHERE ID = ?');
$req->execute([$id]);
$billet = $req->fetch();
if (!$billet) {
    exit('Ce billet n\'existe pas. <a href="index_blog.php">Retour</a>');
}
$billet['date'] = date('d/m/Y H:i', strtotime($billet['date_billet']));

// Commentaires du billet
$req = $pdo->prepare('SELECT nom, comment, date_comment FROM commentaires_blog WHERE ID = ? ORDER BY date_comment ASC');
$req->execute([$id]);
$commentaires = [];
foreach ($req as $c) {
    $commentaires[] = [
        'nom'     => $c['nom'],
        'comment' => $c['comment'],
        'date'    => date('d/m/Y H:i', strtotime($c['date_comment'])),
    ];
}

$smarty->assign('titre', $billet['titre']);
$smarty->assign('billet', $billet);
$smarty->assign('commentaires', $commentaires);
$smarty->display('afficher_blog.tpl');
