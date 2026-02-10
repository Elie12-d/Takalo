<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Catégories</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/sstyle.css">
</head>

<body>
    <div class="container">
        <h1><strong>Catégories</strong></h1>
        <button><a href="<?= BASE_URL ?>/category/add">Ajouter une catégorie</a></button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)){ ?>
                    <?php foreach ($categories as $cat){ ?>
                        <tr>
                            <td><strong>#<?= $cat['id'] ?></strong></td>
                            <td><?= htmlspecialchars($cat['name']) ?></td>
                            <td><?= htmlspecialchars($cat['description']) ?></td>
                            <td><small class='text-muted'><?= $cat['created_at'] ?></small></td>
                            <td>
                                <a href="update/<?= $cat['id'] ?>">modifier</a>
                                <a href="delete/<?= $cat['id'] ?>">delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan='5' class='text-center'>Aucune catégorie trouvée</td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="<?= BASE_URL ?>/assets/js/action.js"></script>
</body>
</html>