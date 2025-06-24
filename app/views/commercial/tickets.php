<body>
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
                    <th>Modifier</th>
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
                                <?php if ($ticket['fk_statut'] != 5 && $ticket['fk_statut'] != 6): ?>
                                    <button class="btn-open-edit"
                                        data-id="<?= $ticket['id'] ?>"
                                        data-subject="<?= htmlspecialchars($ticket['subject'], ENT_QUOTES) ?>"
                                        data-message="<?= htmlspecialchars($ticket['message'], ENT_QUOTES) ?>"
                                        data-statut="<?= $ticket['fk_statut'] ?>">
                                    🖋️Modifier</button>
                                <?php else: ?>
                                    <span style="color: gray;">Fermé</span>
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
<div id="modal-edit" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Modifier le Ticket</h2>
    <form id="edit-form">
        <input type="hidden" name="id" id="edit-id">
        <label>Sujet :</label>
        <input type="text" name="subject" id="edit-subject" required><br>
        
        <label>Message :</label>
        <textarea name="message" id="edit-message" required></textarea><br>
        
        <label>Statut :</label>
        <select name="fk_statut" id="edit-statut" required>
            <?php for($i = 0 ; $i < count($statut); $i++){ ?>
                <option value="<?php echo $i ?>" ><?php echo $statut[$i] ?></option>
            <?php } ?>
        </select><br>


        <button type="submit" class="btn-edit">Enregistrer</button>

    </form>
  </div>
</div>
<script>
document.querySelectorAll('.btn-open-edit').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const id = this.dataset.id;
        const subject = this.dataset.subject;
        const message = this.dataset.message;
        const statutText = this.dataset.statut;

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-subject').value = subject;
        document.getElementById('edit-message').value = message;
        document.getElementById('edit-statut').value = statutText;

        document.getElementById('modal-edit').style.display = 'block';
    });
});

document.querySelector('.close').onclick = function() {
    document.getElementById('modal-edit').style.display = 'none';
};

window.onclick = function(event) {
    if (event.target == document.getElementById('modal-edit')) {
        document.getElementById('modal-edit').style.display = 'none';
    }
};

document.getElementById('edit-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch('ticket/update', {
        method: 'POST',
        body: formData
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              alert('Ticket mis à jour avec succès');
              location.reload();
          } else {
              alert('Erreur : ' + data.error);
          }
      });
});
</script>

</body>
<style>
    .btn-edit {
    padding: 6px 10px;
    background-color: #f39c12;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
}

.btn-edit:hover {
    background-color: #d68910;
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
.modal {
    display: none; 
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    position: relative;
}

.modal-content input, .modal-content textarea, .modal-content select {
    width: 100%;
    padding: 8px;
    margin-top: 6px;
    margin-bottom: 12px;
}

.close {
    color: #aaa;
    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

</style>
