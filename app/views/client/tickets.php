<div class="ticket-container">
    <h1>Mes Tickets</h1>

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
                    <th>Agent Responsable</th>
                    <th>Statut</th>
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
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', sans-serif;
}

.ticket-container h1 {
    text-align: center;
    color: #2980b9;
    margin-bottom: 25px;
}

.ticket-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}

.ticket-table th,
.ticket-table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

.ticket-table th {
    background-color: #2980b9;
    color: white;
}

.ticket-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.ticket-table tr:hover {
    background-color: #f1f1f1;
}

.no-ticket {
    text-align: center;
    padding: 20px;
    color: #e74c3c;
    font-weight: bold;
}
</style>
