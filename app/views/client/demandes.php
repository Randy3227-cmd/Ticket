<div class="demande-container">
    <h1>Mes demandes de tickets</h1>
    <ul class="demande-list">
        <?php foreach ($demandes as $demande): ?>
            <li>
                <strong>Sujet:</strong> <?php echo htmlspecialchars($demande['sujet']); ?><br>
                <strong>Message:</strong> <?php echo nl2br(htmlspecialchars($demande['message'])); ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<style>
.demande-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', sans-serif;
}

.demande-container h1 {
    text-align: center;
    color: #2980b9;
    margin-bottom: 25px;
}

.demande-list {
    list-style: none;
    padding: 0;
}

.demande-list li {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

.demande-list li:hover {
    background-color: #f1f1f1;
}

.demande-list strong {
    color: #34495e;
}
</style>
