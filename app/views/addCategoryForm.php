<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une categorie</title>
</head>

<body>
    <form action="<?=  BASE_URL ?>/category/add" method="post">
        <input type="text" placeholder="Nom de la catégorie" name="nom">
        <textarea placeholder="Description de la catégorie" name="description"></textarea>
        <button>Ajouter</button>
    </form>
</body>

</html>