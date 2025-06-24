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
