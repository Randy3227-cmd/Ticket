<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Animaux</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f5f5f5;
    }

    h1 {
        text-align: center;
    }

    .animaux-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .animal-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        width: 250px;
        text-align: center;
    }

    .animal-card img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .animal-info {
        text-align: left;
    }

    .btn-acheter {
        background-color: green;
        color: white;
        border: none;
        padding: 8px 15px;
        margin-top: 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn-acheter:hover {
        background-color: darkgreen;
    }
    </style>
</head>

<body>

    <h2>Gestion des Animaux</h2>

    <!-- Formulaire de sélection de date -->
    <form id="dateForm">
        <label for="dateInput">Sélectionnez une date :</label>
        <input type="date" id="dateInput" required>
        <button type="submit">Valider</button>
    </form>

    <br>

    <h1>Liste des Animaux</h1>

    <div class="animaux-container">
        <?php foreach ($animaux as $animal) : ?>
        <!-- if(in_array($animaux , getANu)) -->
        <div class="animal-card">
            <?php if (!empty($animal['imageAnimaux'])) : ?>
            <img src="<?= 'public/assets/img/' . htmlspecialchars($animal['imageAnimaux']) ?>"
                alt="Image de <?= htmlspecialchars($animal['animal']) ?>">
            <?php else : ?>
            <p>Pas d'image</p>
            <?php endif; ?>

            <h3><?= htmlspecialchars($animal['animal']) ?></h3>

            <div class="animal-info">
                <p><strong>Poids Min:</strong> <?= htmlspecialchars($animal['poidsMin']) ?> kg</p>
                <p><strong>Poids Max:</strong> <?= htmlspecialchars($animal['poidsMax']) ?> kg</p>
                <p><strong>Prix Vente:</strong> <?= htmlspecialchars($animal['prixVenteParKg']) ?> MGA/kg</p>
                <p><strong>Poids Initial:</strong> <?= htmlspecialchars($animal['poidsInitial']) ?> kg</p>
                <p><strong>Poids Actuel:</strong> <span class="actualPoids"
                        data-id="<?= $animal['idAnimaux'] ?>"><?= htmlspecialchars($animal['poidsInitial']) ?></span>
                    kg</p>
                <p><strong>Prix Actuel:</strong> <span class="prixActuel"
                        data-id="<?= $animal['idAnimaux'] ?>"><?= htmlspecialchars($animal['poidsInitial'] * $animal['prixVenteParKg']) ?></span>
                    MGA</p>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <script>
    $(document).ready(function() {
        $("#dateForm").submit(function(event) {
            event.preventDefault();
            let selectedDate = $("#dateInput").val();

            if (selectedDate) {
                $(".actualPoids").each(function() {
                    let idAnimaux = $(this).data("id");
                    let poidsSpan = $(this);
                    let prixSpan = $(".prixActuel[data-id='" + idAnimaux + "']");

                    $.ajax({
                        url: "<?= BASE_URL ?>/situation/getPoidsActuel",
                        type: "POST",
                        data: {
                            date: selectedDate,
                            idAnimaux: idAnimaux
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log("Réponse reçue :", response);
                            if (response.success) {
                                poidsSpan.text(response.actualPoids);
                                prixSpan.text(response.actualPrix);
                            } else {
                                poidsSpan.text("Erreur");
                                prixSpan.text("Erreur");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Erreur AJAX:", xhr.responseText);
                        }
                    });
                });
            }
        });
    });
    </script>

</body>

</html>