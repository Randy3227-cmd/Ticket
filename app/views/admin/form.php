<div class="form-container">
    <h2>Créer un nouveau ticket</h2>

    <?php if(isset($_GET['error'])): ?>
        <p class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <?php if(isset($_GET['success'])): ?>
        <p class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/admin/demandes/create" method="post">
        <input type="hidden" name="id_demande" value="<?= $demande['id_demande'] ?? '' ?>">
        <input type="hidden" name="id_client" value="<?= $demande['id_client'] ?? '' ?>">

        <div class="form-group">
            <label for="type">Type de demande :</label>
            <select name="type" id="type">
                <option value="1">Commercial</option>
                <option value="2">Demande de soutien</option>
                <option value="3">Bug</option>
                <option value="4">Problème</option>
                <option value="5">Demande</option>
                <option value="7">Autre</option>
            </select>
        </div>

        <div class="form-group">
            <label for="categorie">Catégorie :</label>
            <select name="categorie" id="categorie">
                <option value="1">Autre</option>
            </select>
        </div>

        <div class="form-group">
            <label for="severity">Priorité :</label>
            <select name="severity" id="severity">
                <option value="1">Basse</option>
                <option value="2">Normale</option>
                <option value="3">Haute</option>
            </select>
        </div>

        <div class="form-group">
            <label for="subject">Objet :</label>
            <input type="text" id="subject" name="subject" required value="<?= htmlspecialchars($demande['sujet'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="message">Message :</label>
            <textarea id="message" name="message" required><?= htmlspecialchars($demande['message'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="id_agent">Agent attribué :</label>
            <select name="id_agent" id="id_agent">
                <option value="">Sélectionner un agent</option>
                <?php foreach ($agents as $agent): ?>
                    <option value="<?= htmlspecialchars($agent['id_agent']) ?>">
                        <?= htmlspecialchars($agent['nom_agent']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-submit">Créer le ticket</button>
        </div>
    </form>
</div>

<style>
.form-container {
    max-width: 800px;
    margin: 30px auto;
    background-color: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', sans-serif;
}

.form-container h2 {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

input[type="text"],
textarea,
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccd1d1;
    border-radius: 4px;
    font-size: 1rem;
}

textarea {
    height: 120px;
    resize: vertical;
}

.btn-submit {
    padding: 10px 20px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-submit:hover {
    background-color: #21618c;
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
