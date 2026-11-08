<html>
<head>
<title>{$titre|escape}</title>
{literal}
<style>
body { font-family: sans-serif; font-size: 12px; }
h1 { font-size: 20px; }
.commentaire { margin-bottom: 10px; }
.commentaire .qui { font-weight: bold; }
#formulaire_commentaire { display: none; }
</style>
<script>
function afficher_formulaire() {
    document.getElementById('formulaire_commentaire').style.display = 'block';
    document.getElementById('lien_commenter').style.display = 'none';
}
</script>
{/literal}
</head>
<body>
<a href="index_blog.php">Mon blog</a>

<h1>{$billet.titre|escape}</h1>
<p>{$billet.date}</p>
<p>{$billet.contenu|escape|nl2br}</p>
<p>Catégorie : <a href="index_blog.php?categorie={$billet.categorie|escape:'url'}">{$billet.categorie|escape}</a></p>

<h3>Commentaires</h3>
{section name=i loop=$commentaires}
<div class="commentaire">
    <span class="qui">{$commentaires[i].nom|escape}</span> — {$commentaires[i].date}<br />
    {$commentaires[i].comment|escape|nl2br}
</div>
{sectionelse}
<p>Aucun commentaire pour le moment.</p>
{/section}

<a id="lien_commenter" href="javascript:afficher_formulaire();">Ajouter un commentaire</a>

<form id="formulaire_commentaire" method="post" action="commenter_blog.php">
    <input type="hidden" name="ID" value="{$billet.ID}" />
    <p>Nom : <input type="text" name="nom" maxlength="50" /></p>
    <p>Commentaire :<br /><textarea name="comment" rows="5" cols="40"></textarea></p>
    <p><input type="submit" value="Commenter" /></p>
</form>
</body>
</html>
