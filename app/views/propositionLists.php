<div class="container py-5">

        <h1 class="text-center mb-5 fw-bold">
            Liste des propositions
        </h1>

        <div class="card custom-card p-4">

            <div class="table-responsive">
                <table class="table align-middle text-center mb-0">

                    <thead class="custom-header">
                        <tr>
                            <th>Utilisateur proposant</th>
                            <th>Utilisateur recevant</th>
                            <th>Objet proposé</th>
                            <th>Objet demandé</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($propositions as $proposition) : ?>
                        <tbody>
                            <tr>
                            <td><?= htmlspecialchars($proposition['user1_id']) ?></td>
                            <td><?= htmlspecialchars($proposition['user2_id']) ?></td>
                            <td><?= htmlspecialchars($proposition['object1_id']) ?></td>
                            <td><?= htmlspecialchars($proposition['object2_id']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-3">
                                    <button class="btn btn-accept px-4" onclick="acceptProposition(<?= $proposition['id'] ?>)">
                                        Accepter
                                    </button>
                                    <button class="btn btn-refuse px-4" onclick="rejectProposition(<?= $proposition['id'] ?>)">
                                        Refuser
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                    
                </table>
            </div>

        </div>

    </div>
    <script>
        function acceptProposition(propositionId) {
            fetch('<?= BASE_URL ?>/products/exchange/accept/' + propositionId, {
                    method: 'POST'
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Proposition acceptée avec succès!');
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'acceptation de la proposition.');
                    }
                }).catch(error => {
                    console.error('Erreur:', error);
                });
        }

        function rejectProposition(propositionId) {
            fetch('<?= BASE_URL ?>/products/exchange/reject/' + propositionId, {
                    method: 'POST'
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Proposition refusée avec succès!');
                        location.reload();
                    } else {
                        alert('Erreur lors du refus de la proposition.');
                    }
                }).catch(error => {
                    console.error('Erreur:', error);
                });
        }
    </script>