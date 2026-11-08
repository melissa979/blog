<html>
<head>
<title>{$titre|escape}</title>
{literal}
<style>
body { font-family: sans-serif; }
table.billets { font-size: 12px; }
table.billets td { padding-bottom: 7px; }
.entete { font-size: 14px; font-weight: bold; }
</style>
{/literal}
</head>
<body>
<a href="index_blog.php">Mon blog</a> | <a href="editer_blog.php">Nouveau billet</a>
{if $categorie != ''}<p>Catégorie : <b>{$categorie|escape}</b></p>{/if}

<table class="billets">
{section name=i loop=$billets}
<tr><td>
    <a class="entete" href="afficher_blog.php?ID={$billets[i].ID}">{$billets[i].titre|escape}</a><br />
    {$billets[i].date}<br />
    {$billets[i].annonce|escape}<br />
    Catégorie : <a href="index_blog.php?categorie={$billets[i].categorie|escape:'url'}">{$billets[i].categorie|escape}</a>
</td></tr>
{sectionelse}
<tr><td>Aucun billet.</td></tr>
{/section}
</table>
</body>
</html>
