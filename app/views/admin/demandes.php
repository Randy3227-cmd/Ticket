<div class="container">
    <h1>Demandes</h1>
    <?php if(isset($_GET['error'])): ?>
        <p class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <?php if(isset($_GET['success'])): ?>
        <p class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
    <?php if (!empty($demandes) && is_array($demandes)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Nom du client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($demandes as $demande): ?>
                <tr>
                    <td><?= htmlspecialchars($demande['id_demande']) ?></td>
                    <td><?= htmlspecialchars($demande['sujet']) ?></td>
                    <td><?= htmlspecialchars($demande['message']) ?></td>
                    <td><?= htmlspecialchars($demande['nom_client']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/demandes/create?id=<?= $demande['id_demande'] ?>" class="btn btn-primary">Traiter</a>
                        <a href="<?= BASE_URL ?>/admin/demandes/refuser?id=<?= $demande['id_demande'] ?>" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette demande ?');">Refuser</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p class="no-data">Aucune demande trouvée.</p>
    <?php endif; ?>
</div>

<style>
.container {
    max-width: 900px;
    margin: 30px auto;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}

.container h1 {
    text-align: center;
    color: #2980b9;
    margin-bottom: 25px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, 
.table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #3498db;
    color: #fff;
}

.table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tr:hover {
    background-color: #eef5fb;
}

.btn {
    display: inline-block;
    padding: 7px 12px;
    margin: 0 4px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
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

.no-data {
    text-align: center;
    color: #e74c3c;
    font-weight: bold;
    margin-top: 20px;
}
.alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
}

.alert-error {
    background-color: #f8d7da;
    color: #a94442;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}
</style>
