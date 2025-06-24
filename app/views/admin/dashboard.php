<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        
        .dashboard-section {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .dashboard-section h3 {
            color: #495057;
            margin-top: 0;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        
        .metric-box {
            background: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
        }
        
        .form-inline {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .form-inline label {
            font-weight: bold;
        }
        
        .form-inline select,
        .form-inline input[type="number"] {
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-inline button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .form-inline button:hover {
            background: #0056b3;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        
        .data-table th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
        }
        
        .data-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .chart-container {
            width: 100%;
            height: 400px;
            margin-top: 20px;
        }
        
        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
        
        .agent-rating {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.9em;
        }
        
        .rating-low { background: #dc3545; }
        .rating-medium { background: #ffc107; color: #000; }
        .rating-high { background: #28a745; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2><?= htmlspecialchars($title) ?></h2>

        <!-- Section 1: Temps moyen de résolution -->
        <div class="dashboard-section">
            <h3>1. Temps moyen de résolution des tickets</h3>
            <div class="metric-box">
                <?= number_format($avgResolutionTime, 1) ?> jours
            </div>
        </div>

        <!-- Section 2: Statistiques des tickets -->
        <div class="dashboard-section">
            <h3>2. Statistiques des tickets par jour</h3>
            <form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>" class="form-inline">
                <label for="month">Mois:</label>
                <select name="month" id="month">
                    <?php 
                    $months = [
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                    ];
                    foreach ($months as $num => $name): ?>
                        <option value="<?= $num ?>" <?= $num == $selectedMonth ? 'selected' : '' ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="year">Année:</label>
                <select name="year" id="year">
                    <?php for ($y = date('Y') - 2; $y <= date('Y'); $y++): ?>
                        <option value="<?= $y ?>" <?= $y == $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>

                <input type="hidden" name="top_agents" value="<?= $topAgentsLimit ?>">
                <button type="submit">Filtrer</button>
            </form>

            <div class="chart-container">
                <canvas id="ticketStatsChart"></canvas>
            </div>
        </div>

        <!-- Section 3: Meilleurs agents -->
        <div class="dashboard-section">
            <h3>3. Top des meilleurs agents</h3>
            <form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>" class="form-inline">
                <label for="top_agents">Nombre d'agents à afficher:</label>
                <input type="number" name="top_agents" id="top_agents" min="1" max="50" value="<?= $topAgentsLimit ?>">
                <input type="hidden" name="month" value="<?= $selectedMonth ?>">
                <input type="hidden" name="year" value="<?= $selectedYear ?>">
                <button type="submit">Afficher</button>
            </form>

            <?php if (!empty($topAgents)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Agent</th>
                            <th>Note moyenne</th>
                            <th>Nombre d'évaluations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topAgents as $index => $agent): ?>
                            <?php 
                            $rating = (float)$agent['moyenne_note'];
                            $ratingClass = $rating >= 4 ? 'rating-high' : ($rating >= 2.5 ? 'rating-medium' : 'rating-low');
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($agent['prenom_agent'] . ' ' . $agent['nom_agent']) ?></td>
                                <td>
                                    <span class="agent-rating <?= $ratingClass ?>">
                                        <?= number_format($rating, 1) ?>/5
                                    </span>
                                </td>
                                <td><?= (int)$agent['nombre_evaluations'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">Aucun agent trouvé.</div>
            <?php endif; ?>
        </div>

        <!-- Section 4: Commentaires sur les agents -->
        <div class="dashboard-section">
            <h3>4. Commentaires et évaluations des agents</h3>
            <?php if (!empty($agentComments)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Agent</th>
                            <th>Client</th>
                            <th>Note</th>
                            <th>Commentaire</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agentComments as $comment): ?>
                            <?php 
                            $rating = (float)$comment['note'];
                            $ratingClass = $rating >= 4 ? 'rating-high' : ($rating >= 2.5 ? 'rating-medium' : 'rating-low');
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($comment['prenom_agent'] . ' ' . $comment['nom_agent']) ?></td>
                                <td><?= htmlspecialchars($comment['nom_client']) ?></td>
                                <td>
                                    <span class="agent-rating <?= $ratingClass ?>">
                                        <?= $rating ?>/5
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($comment['commentaires']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($comment['date_note'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">Aucun commentaire disponible.</div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ticketStatsChart').getContext('2d');
            const chartData = <?= json_encode($chartData) ?>;

            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            title: {
                                display: true,
                                text: 'Nombre de tickets'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Jour du mois'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Statistiques des tickets pour <?= $months[$selectedMonth] ?> <?= $selectedYear ?>'
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>