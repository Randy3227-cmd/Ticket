<?php

namespace app\models;

use Exception;
use Flight;

class DolibarrModel
{
    private $apiUrl = 'http://localhost/dolibarr-21.0.1/htdocs/api/index.php/';



    private $apiKey = 'VpAJ7j10Q0KfmBqkqp05Q0xT39Ic5AzZ'; // Riana
    // private $apiKey = '3d8VLS2o0PLypI8OA9vkG0a1zY65Miwf'; // Randy

    public function __construct()
    {
    }

    public function createDolibarrTicket($params): array
    {
        // Paramètres obligatoires avec valeurs par défaut
        $defaultParams = [
            'subject' => 'Sans objet',
            'message' => '',
            'fk_user_create' => 1,
            'fk_user_assign' => 1,
            'fk_statut' => 2,
            'type_code' => 'OTHER',
            'category_code' => 'OTHER',
            'severity_code' => 'NORMAL'
        ];

        // Fusion des paramètres avec les valeurs par défaut
        $ticketData = array_merge($defaultParams, $params);

        // Validation des paramètres obligatoires
        if (empty($ticketData['message'])) {
            return ['error' => 'Le message du ticket est obligatoire'];
        }

        // Préparation de l'URL API
        $apiEndpoint = rtrim($this->apiUrl, '/') . '/tickets';

        // Initialisation cURL
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($ticketData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'DOLAPIKEY: ' . $this->apiKey,
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10
        ]);

        // Exécution de la requête
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Gestion des erreurs cURL
        if ($response === false) {
            return ['error' => 'Erreur cURL : ' . $curlError];
        }

        // Décodage de la réponse
        $result = json_decode($response, true);

        // Vérification que le décodage JSON a réussi
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Erreur de décodage JSON: ' . json_last_error_msg()];
        }

        // Gestion des erreurs API
        if ($httpCode !== 200) {
            $errorMsg = is_array($result) ? ($result['error'] ?? $response) : $response;
            return ['error' => "Erreur API Dolibarr ($httpCode) : " . $errorMsg];
        }

        // Vérification que la réponse contient bien les champs attendus
        if (!is_array($result) || !isset($result['id']) || !isset($result['ref'])) {
            return ['error' => 'Réponse API invalide', 'response' => $result];
        }

        // Retourne les données du ticket créé
        return [
            'success' => true,
            'ticket_id' => $result['id'],
            'ticket_ref' => $result['ref'],
            'status' => $result['status'] ?? null,
            'message' => 'Ticket créé avec succès'
        ];
    }

    public function getDolibarrTicket($ticketId): array
    {
        $apiEndpoint = rtrim($this->apiUrl, '/') . '/api/index.php/tickets/' . $ticketId;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'DOLAPIKEY: ' . $this->apiKey,
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 15
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return ['error' => "Erreur lors de la récupération du ticket (HTTP $httpCode)"];
        }

        return json_decode($response, true);
    }

    public function updateDolibarrTicket($ticketId, $updateData): array
    {
        $apiEndpoint = rtrim($this->apiUrl, '/') . '/tickets/' . $ticketId;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($updateData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'DOLAPIKEY: ' . $this->apiKey
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return ['error' => "Erreur lors de la mise à jour du ticket (HTTP $httpCode)"];
        }

        return json_decode($response, true);
    }

    public function findAllTickets(): array
    {
        $apiEndpoint = rtrim($this->apiUrl, '/') . '/tickets';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'DOLAPIKEY: ' . $this->apiKey,
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 15
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return ['error' => "Erreur lors de la récupération des tickets (HTTP $httpCode)"];
        }

        return json_decode($response, true);
    }

    public function findTicketsByExternalUserId($externalUserId): array
    {
        $allTickets = $this->findAllTickets();

        if (isset($allTickets['error'])) {
            return ['error' => $allTickets['error']];
        }

        return array_filter($allTickets, function ($ticket) use ($externalUserId) {
            return isset($ticket['array_options']['options_userid_external'])
                && $ticket['array_options']['options_userid_external'] == $externalUserId;
        });
    }

    public function findTicketsByExternalAgentId($externalAgentId): array
    {
        $allTickets = $this->findAllTickets();

        if (isset($allTickets['error'])) {
            return ['error' => $allTickets['error']];
        }

        return array_filter($allTickets, function ($ticket) use ($externalAgentId) {
            return isset($ticket['array_options']['options_agentid_external'])
                && $ticket['array_options']['options_agentid_external'] == $externalAgentId;
        });
    }
}
