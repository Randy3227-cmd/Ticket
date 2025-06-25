<?php

namespace app\models;

use Exception;

class DashboardModel
{
    private $db;
    private $dolibarrModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->dolibarrModel = new DolibarrModel();
    }

    // 1. Liste des n meilleurs agents avec note moyenne
    public function getTopAgents($limit)
    {
        // Force le paramètre à être un entier
        $limit = (int)$limit;
        
        $query = "SELECT a.id_agent, a.nom_agent, a.prenom_agent, 
                  COALESCE(AVG(n.note), 0) as moyenne_note,
                  COUNT(n.note) as nombre_evaluations
                  FROM agent a
                  LEFT JOIN notes n ON a.id_agent = n.id_agent
                  GROUP BY a.id_agent, a.nom_agent, a.prenom_agent
                  ORDER BY moyenne_note DESC
                  LIMIT $limit";

        return $this->db->fetchAll($query);
    }

    // 2. Commentaires reçus par les agents
    public function getAgentComments()
    {
        $query = "SELECT n.note, a.nom_agent, a.prenom_agent, 
                  n.commentaires, c.nom_client, n.date_note
                  FROM notes n
                  JOIN agent a ON n.id_agent = a.id_agent
                  JOIN client c ON n.id_client = c.id_client
                  WHERE n.commentaires IS NOT NULL AND n.commentaires != ''
                  ORDER BY n.date_note DESC";

        return $this->db->fetchAll($query);
    }

    // 3. Temps moyen de résolution des tickets (via Dolibarr)
    public function getAverageResolutionTime()
{
    try {
        $tickets = $this->dolibarrModel->findAllTickets();

        if (isset($tickets['error'])) {
            throw new Exception("Erreur de récupération des tickets");
        }

        $totalSeconds = 0;
        $count = 0;

        foreach ($tickets as $ticket) {
            if ($ticket['fk_statut'] == 5) {
                $creationTimestamp = (is_numeric($ticket['array_options']['options_date_creation']) && $ticket['array_options']['options_date_creation'] > 0)
                    ? (int) $ticket['array_options']['options_date_creation']
                    : 0;

                $closeTimestamp = (is_numeric($ticket['array_options']['options_date_fin']) && $ticket['array_options']['options_date_fin'] > 0)
                    ? (int) $ticket['array_options']['options_date_fin']
                    : 0;

                $diffInSeconds = max(0, $closeTimestamp - $creationTimestamp);
                $totalSeconds += $diffInSeconds;
                $count++;
            }
        }

        if ($count === 0) {
            return 0;
        }

        $averageSeconds = (int)($totalSeconds / $count);
        $days = floor($averageSeconds / 86400);
        $hours = floor(($averageSeconds % 86400) / 3600);
        $minutes = floor(($averageSeconds % 3600) / 60);
        $seconds = $averageSeconds % 60;

        return "$days jour(s) $hours h $minutes min $seconds s";

    } catch (\Throwable $e) {
        throw new \RuntimeException("Erreur dans getAverageResolutionTime() : " . $e->getMessage());
    }
}



    // 4. Statistiques tickets par jour
    public function getTicketStatsByDay($month, $year)
    {
        try {
            $tickets = $this->dolibarrModel->findAllTickets();
            
            if (isset($tickets['error'])) {
                return $this->getEmptyStats($month, $year);
            }

            $stats = [
                'created' => [],
                'resolved' => [],
                'abandoned' => []
            ];

            // Initialiser tous les jours du mois
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $stats['created'][$day] = 0;
                $stats['resolved'][$day] = 0;
                $stats['abandoned'][$day] = 0;
            }

            foreach ($tickets as $ticket) {
                // Traitement des tickets créés
                if (isset($ticket['array_options']['options_date_creation'])) {
                    $date = new \DateTime('@' . $ticket['array_options']['options_date_creation']);
                    $day = (int)$date->format('d');
                    $ticketMonth = (int)$date->format('m');
                    $ticketYear = (int)$date->format('Y');

                    if ($ticketMonth == $month && $ticketYear == $year) {
                        $stats['created'][$day]++;
                    }
                }

                // Traitement des tickets fermés (résolus ou abandonnés)
                if (isset($ticket['array_options']['options_date_fin']) && $ticket['array_options']['options_date_fin'] > 0) {
                    $closeDate = new \DateTime('@' . $ticket['array_options']['options_date_fin']);
                    $closeDay = (int)$closeDate->format('d');
                    $closeMonth = (int)$closeDate->format('m');
                    $closeYear = (int)$closeDate->format('Y');

                    if ($closeMonth == $month && $closeYear == $year) {
                        if ($ticket['fk_statut'] == 5) { // Résolu
                            $stats['resolved'][$closeDay]++;
                        } elseif ($ticket['fk_statut'] == 6) { // Abandonné
                            $stats['abandoned'][$closeDay]++;
                        }
                    }
                }
            }

            return $stats;
        } catch (Exception $e) {
            return $this->getEmptyStats($month, $year);
        }
    }

    // Méthode helper pour retourner des statistiques vides
    private function getEmptyStats($month, $year)
    {
        $stats = [
            'created' => [],
            'resolved' => [],
            'abandoned' => []
        ];

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $stats['created'][$day] = 0;
            $stats['resolved'][$day] = 0;
            $stats['abandoned'][$day] = 0;
        }

        return $stats;
    }
}






