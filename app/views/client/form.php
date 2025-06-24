<div class="form-wrapper">
    <?php
    if (isset($_GET['error'])) {
        echo '<p class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    if (isset($_GET['success'])) {
        echo '<p class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</p>';
    }
    ?>
    <h2>Créer une Demande de Ticket</h2>
    <form action="<?= BASE_URL ?>/client/demandes/create" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="sujet">Sujet :</label>
            <input type="text" id="sujet" name="sujet" required>
        </div>
        <div class="form-group">
            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="fichier">Joindre un fichier :</label>
            <input type="file" id="fichier" name="fichier">
        </div>
        <button type="submit" class="submit-btn">Envoyer la Demande</button>
    </form>
</div>

<style>
    .form-wrapper {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
        color: #2c3e50;
    }

    h2 {
        color: #2980b9;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: 500;
        display: block;
        margin-bottom: 8px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .submit-btn {
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        font-size: 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #2980b9;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }

    .alert-error {
        background-color: #fdecea;
        color: #e74c3c;
        border: 1px solid #e0b4b4;
    }

    .alert-success {
        background-color: #eafaf1;
        color: #27ae60;
        border: 1px solid #b4e0c2;
    }
</style>