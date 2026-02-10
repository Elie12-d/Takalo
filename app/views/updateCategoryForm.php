<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre a jour le categorie</title>
</head>

<body>
    <form action="<?= BASE_URL ?>/category/update" method="POST">
        <input type="hidden" name="id" value="<?= $categorie['id'] ?>">
        <input type="text" name="name" value="<?= $categorie['name'] ?>">
        <textarea name="description"><?= $categorie['description'] ?></textarea>
        <select name="status">
            <option value="active" <?= $categorie['status'] == 'active' ? 'selected' : '' ?>>Actif</option>
            <option value="inactive" <?= $categorie['status'] == 'inactive' ? 'selected' : '' ?>>Inactif</option>
        </select>

        <button type="submit">Mettre à jour</button>
    </form>
</body>

</html>