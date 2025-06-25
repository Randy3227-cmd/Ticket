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
                            <td>
                                <?php if (strtolower($statut[$ticket['fk_statut']]) === 'résolu'): ?>
                                    <div class="evaluation" 
                                        data-id="<?= $ticket['id'] ?>" 
                                        data-client="<?= $_SESSION['id_client'] ?>" 
                                        data-agent="<?= $ticket['array_options']['options_agentid_external'] ?>">
                                        <span>Évaluez :</span>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star" data-note="<?= $i ?>">★</span>
                                        <?php endfor; ?>
                                        <div class="commentaire" style="display:none; margin-top: 10px;">
                                            <textarea class="comment-text" placeholder="Laissez un commentaire..."></textarea><br>
                                            <button class="btn-comment">Envoyer le commentaire</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-ticket">Aucun ticket trouvé ou erreur de chargement.</p>
    <?php endif; ?>
</div>
<script>
document.querySelectorAll('.evaluation').forEach(container => {
    const stars = container.querySelectorAll('.star');
    let selectedNote = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const note = parseInt(star.dataset.note);
            stars.forEach(s => {
                s.classList.toggle('hover', parseInt(s.dataset.note) <= note);
            });
        });

        star.addEventListener('mouseout', () => {
            stars.forEach(s => s.classList.remove('hover'));
        });
        const BASE_URL = "<?= htmlspecialchars(BASE_URL) ?>";
        star.addEventListener('click', () => {
            selectedNote = parseInt(star.dataset.note);
            const id_client = container.dataset.client;
            const id_agent = container.dataset.agent;

            stars.forEach(s => {
                s.classList.toggle('selected', parseInt(s.dataset.note) <= selectedNote);
            });

            const commentBox = container.querySelector('.commentaire');
            commentBox.style.display = 'block';

            const commentBtn = commentBox.querySelector('.btn-comment');
            commentBtn.addEventListener('click', () => {
                const commentaire = commentBox.querySelector('.comment-text').value;

                fetch(BASE_URL + '/ticket/evaluation', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `id_client=${id_client}&id_agent=${id_agent}&note=${selectedNote}&commentaire=${encodeURIComponent(commentaire)}`
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        alert('Merci pour votre évaluation !');
                        commentBox.style.display = 'none';
                    } else {
                        alert(res.error || 'Erreur lors de l’envoi.');
                    }
                });
            }, { once: true }); // évite doublons
        });
    });
});

</script>


<style>
.star {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
}
.star.selected,
.star.hover {
    color: gold;
}

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
.commentaire textarea {
    width: 100%;
    height: 60px;
    padding: 5px;
    resize: vertical;
}

</style>
