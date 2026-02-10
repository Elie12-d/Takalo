<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
</head>

<body>
    <?php foreach ($objects as $object) { ?>
        <h2><?= $object['name'] ?></h2>
        <p><?= $object['description'] ?></p>
        <p>Propriétaire: <?= $object['username'] ?></p>
        <p>Catégorie ID: <?= $object['category_id'] ?></p>
        <p>Publié le: <?= $object['published_at'] ?></p>
        <button><a href="<?= BASE_URL ?>/products/exchange">Echanger</a></button>
        <hr>
    <?php } ?>
</body>

</html>