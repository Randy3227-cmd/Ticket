<?php

namespace app\controllers;

use app\models\DashboardModel;
use Flight;

class DashboardController
{
    public function __construct()
    {
        
    }

    public function showDashboard()
    {
        // Debug : vérifier que la méthode est appelée
        error_log("Dashboard controller called");
        error_log("Request URI: " . $_SERVER['REQUEST_URI']);
        error_log("Query params: " . print_r($_GET, true));
        
        // Récupérer les paramètres avec validation
        $topAgentsLimit = Flight::request()->query['top_agents'] ?? 5;
        $month = Flight::request()->query['month'] ?? date('m');
        $year = Flight::request()->query['year'] ?? date('Y');

        // Debug : vérifier les paramètres
        error_log("Top agents limit: $topAgentsLimit");
        error_log("Month: $month, Year: $year");

        // Valider que les paramètres sont corrects
        if (!is_numeric($topAgentsLimit) || $topAgentsLimit <= 0) {
            $topAgentsLimit = 5;
        }
        $topAgentsLimit = (int) $topAgentsLimit;

        if (!is_numeric($month) || $month < 1 || $month > 12) {
            $month = date('m');
        }
        $month = (int) $month;

        if (!is_numeric($year) || $year < 2020 || $year > date('Y')) {
            $year = date('Y');
        }
        $year = (int) $year;

        // Instancier le modèle
        $dashboardModel = new DashboardModel(Flight::db());

        // Récupérer les données
        $topAgents = $dashboardModel->getTopAgents($topAgentsLimit);
        $agentComments = $dashboardModel->getAgentComments();
        $avgResolutionTime = $dashboardModel->getAverageResolutionTime();
        $ticketStats = $dashboardModel->getTicketStatsByDay($month, $year);

        // Préparer les données pour le graphique
        $chartData = [
            'labels' => array_keys($ticketStats['created']),
            'datasets' => [
                [
                    'label' => 'Tickets créés',
                    'data' => array_values($ticketStats['created']),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Tickets résolus',
                    'data' => array_values($ticketStats['resolved']),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Tickets abandonnés',
                    'data' => array_values($ticketStats['abandoned']),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        // Debug : vérifier les données
        error_log("Chart data prepared");
        
        // Rendu de la vue
        Flight::render('admin/dashboard', [
            'title' => 'Tableau de bord',
            'topAgents' => $topAgents,
            'agentComments' => $agentComments,
            'avgResolutionTime' => $avgResolutionTime,
            'chartData' => $chartData,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'topAgentsLimit' => $topAgentsLimit
        ]);
    }
}