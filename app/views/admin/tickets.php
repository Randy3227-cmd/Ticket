<section class="search-form">
    <form action="<?= BASE_URL ?>/admin/recherche" method="POST">
        <div class="form-row">
            <label for="sujet">Sujet :</label>
            <input type="text" id="sujet" name="sujet" value="<?= htmlspecialchars($currentFilters['sujet'] ?? '') ?>">

            <label for="message">Message :</label>
            <input type="text" id="message" name="message" value="<?= htmlspecialchars($currentFilters['message'] ?? '') ?>">

            <label for="priorite">Priorité :</label>
            <select id="priorite" name="priorite">
                <option value="">-- Toutes --</option>
                <option value="1" <?= ($currentFilters['priorite'] ?? '') == '1' ? 'selected' : '' ?>>Low</option>
                <option value="2" <?= ($currentFilters['priorite'] ?? '') == '2' ? 'selected' : '' ?>>Normal</option>
                <option value="3" <?= ($currentFilters['priorite'] ?? '') == '3' ? 'selected' : '' ?>>High</option>
            </select>

            <label for="type">Type :</label>
            <select id="type" name="type">
                <option value="">-- Tous --</option>
                <option value="1" <?= ($currentFilters['type'] ?? '') == '1' ? 'selected' : '' ?>>Commercial question</option>
                <option value="2" <?= ($currentFilters['type'] ?? '') == '2' ? 'selected' : '' ?>>Request for functional help</option>
                <option value="3" <?= ($currentFilters['type'] ?? '') == '3' ? 'selected' : '' ?>>Issue or bug</option>
                <option value="4" <?= ($currentFilters['type'] ?? '') == '4' ? 'selected' : '' ?>>Problem</option>
                <option value="5" <?= ($currentFilters['type'] ?? '') == '5' ? 'selected' : '' ?>>Change or enhancement request</option>
                <option value="7" <?= ($currentFilters['type'] ?? '') == '7' ? 'selected' : '' ?>>Other</option>
            </select>

            <label for="categorie">Catégorie :</label>
            <input type="number" id="categorie" name="categorie" value="<?= htmlspecialchars($currentFilters['categorie'] ?? '') ?>">

            <label for="client">Client :</label>
            <select name="client" id="client">
                <option value="">-- Tous --</option>
                <?php if (!empty($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= htmlspecialchars($client['id_client']) ?>" 
                                <?= ($currentFilters['client'] ?? '') == $client['id_client'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($client['nom_client']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <label for="agent">Agent responsable :</label>
            <select name="agent" id="agent">
                <option value="">-- Tous --</option>
                <?php if (!empty($agents)): ?>
                    <?php foreach ($agents as $agent): ?>
                        <option value="<?= htmlspecialchars($agent['id_agent']) ?>" 
                                <?= ($currentFilters['agent'] ?? '') == $agent['id_agent'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($agent['nom_agent']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <label for="status">Statut :</label>
            <select id="status" name="status">
                <option value="">-- Tous --</option>
                <option value="0" <?= ($currentFilters['status'] ?? '') == '0' ? 'selected' : '' ?>>Non lu</option>
                <option value="1" <?= ($currentFilters['status'] ?? '') == '1' ? 'selected' : '' ?>>Lu</option>
                <option value="2" <?= ($currentFilters['status'] ?? '') == '2' ? 'selected' : '' ?>>Assigné</option>
                <option value="3" <?= ($currentFilters['status'] ?? '') == '3' ? 'selected' : '' ?>>En cours</option>
                <option value="4" <?= ($currentFilters['status'] ?? '') == '4' ? 'selected' : '' ?>>En attente de retour</option>
                <option value="5" <?= ($currentFilters['status'] ?? '') == '5' ? 'selected' : '' ?>>Résolu</option>
                <option value="6" <?= ($currentFilters['status'] ?? '') == '6' ? 'selected' : '' ?>>Abandonné</option>
            </select>
        </div>
        <div class="form-submit">
            <button type="submit">🔍 Rechercher</button>
            <button type="button" onclick="resetForm()">🔄 Réinitialiser</button>
        </div>
    </form>
</section>

<script>
function resetForm() {
    // Réinitialiser tous les champs du formulaire
    document.getElementById('sujet').value = '';
    document.getElementById('message').value = '';
    document.getElementById('priorite').value = '';
    document.getElementById('type').value = '';
    document.getElementById('categorie').value = '';
    document.getElementById('client').value = '';
    document.getElementById('agent').value = '';
    document.getElementById('status').value = '';
    
    // Optionnel : soumettre automatiquement pour afficher tous les tickets
    // document.querySelector('form').submit();
}
</script>
<div class="ticket-container">
    <h1>Tickets à traiter</h1>

    <?php if (!empty($tickets) && is_array($tickets)): ?>
        <table class="ticket-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sujet</th>
                    <th>Message</th>
                    <th>Priorité</th>
                    <th>Type</th>
                    <th>Catégorie</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Client</th>
                    <th>Agent responsable</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                    <?php if (is_array($ticket)): ?>
                        <tr>
                            <td><?= htmlspecialchars($ticket['id']) ?></td>
                            <td><?= htmlspecialchars($ticket['subject']) ?></td>
                            <td><?= htmlspecialchars($ticket['message']) ?></td>
                            <td><?= htmlspecialchars($ticket['severity_label']) ?></td>
                            <td><?= htmlspecialchars($ticket['type_label']) ?></td>
                            <td><?= htmlspecialchars($ticket['category_label']) ?></td>
                            <td><?= htmlspecialchars($ticket['array_options']['options_date_creation']) ?></td>
                            <td><?= htmlspecialchars($ticket['array_options']['options_date_fin']) ?></td>
                            <td>
                                <?php
                                $client = array_filter($clients, function($c) use ($ticket) {
                                    return $c['id_client'] == $ticket['array_options']['options_userid_external'];
                                });
                                echo !empty($client) ? htmlspecialchars(reset($client)['nom_client']) : 'Inconnu';
                                ?>
                            </td>
                            <td>
                                <?php
                                $agent = array_filter($agents, function($a) use ($ticket) {
                                    return $a['id_agent'] == $ticket['array_options']['options_agentid_external'];
                                });
                                echo !empty($agent) ? htmlspecialchars(reset($agent)['nom_agent']) : 'Inconnu';
                                ?>
                            </td>
                            <td><?= htmlspecialchars($statut[$ticket['fk_statut']]) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-ticket">Aucun ticket trouvé ou erreur de chargement.</p>
    <?php endif; ?>
</div>

<style>
.ticket-container {
    margin: 30px auto;
    padding: 25px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', sans-serif;
    max-width: 1000px;
}

.ticket-container h1 {
    text-align: center;
    margin-bottom: 25px;
    color: #2980b9;
}

.ticket-table {
    width: 100%;
    border-collapse: collapse;
}

.ticket-table th,
.ticket-table td {
    border: 1px solid #ccc;
    padding: 12px;
    text-align: left;
}

.ticket-table th {
    background-color: #3498db;
    color: white;
}

.ticket-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.ticket-table tr:hover {
    background-color: #eef5fb;
}

.btn {
    display: inline-block;
    padding: 8px 12px;
    margin: 0 4px;
    border-radius: 4px;
    font-size: 0.9rem;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s ease;
    color: white;
}

.btn-primary {
    background-color: #27ae60;
}

.btn-primary:hover {
    background-color: #1e8449;
}

.btn-danger {
    background-color: #e74c3c;
}

.btn-danger:hover {
    background-color: #c0392b;
}

.no-ticket {
    text-align: center;
    color: #e74c3c;
    margin-top: 20px;
}
</style>
