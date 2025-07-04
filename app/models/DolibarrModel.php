<?php

namespace app\models;

use Exception;
use Flight;

class DolibarrModel
{
    private $apiUrl = 'http://localhost/dolibarr-21.0.1/htdocs/api/index.php/';

    // private $apiUrl = 'http://localhost/dolibarr/dolibarr-21.0.1/htdocs/api/index.php/'; // Michou



    private $apiKey = 'VpAJ7j10Q0KfmBqkqp05Q0xT39Ic5AzZ'; // Riana
    // private $apiKey = '3d8VLS2o0PLypI8OA9vkG0a1zY65Miwf'; // Randy
    // private $apiKey = 'el6cv75Sz0jSP3Gps9m4B07gfHEDF6TJ'; // Michou

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

        // Retourne les données du ticket créé
        return [
            'success' => true,
            'ticket_id' => $result,
            'message' => 'Ticket créé avec succès'
        ];
    }

    public function getDolibarrTicket($ticketId): array
    {
        $apiEndpoint = rtrim($this->apiUrl, '/') . '/tickets/' . $ticketId;

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

    public function findTickets(array $filters = []): array
{
    $allTickets = $this->findAllTickets();

    if (isset($allTickets['error']) || empty($allTickets)) {
        return $allTickets;
    }

    $filteredTickets = array_filter($allTickets, function ($ticket) use ($filters) {
        foreach ($filters as $key => $value) {
            // Ignorer les valeurs vides ou nulles
            if ($value === '' || $value === null || (is_array($value) && empty($value))) {
                continue;
            }

            // Cas spécial pour les filtres dans array_options
            if ($key === 'array_options' && is_array($value)) {
                foreach ($value as $optionKey => $optionValue) {
                    // Ignorer les valeurs vides ou nulles dans array_options
                    if ($optionValue === '' || $optionValue === null) {
                        continue;
                    }
                    
                    if (!isset($ticket['array_options'][$optionKey]) || $ticket['array_options'][$optionKey] != $optionValue) {
                        return false;
                    }
                }
            } else {
                // Vérifier si le champ existe dans le ticket avant de comparer
                if (!isset($ticket[$key])) {
                    continue; // Ou return false selon votre logique métier
                }
                
                // Comparaison flexible pour les chaînes (recherche partielle)
                if (is_string($value) && is_string($ticket[$key])) {
                    if (stripos($ticket[$key], $value) === false) {
                        return false;
                    }
                } else {
                    // Comparaison exacte pour les autres types
                    if ($ticket[$key] != $value) {
                        return false;
                    }
                }
            }
        }
        return true;
    });

    return array_values($filteredTickets);
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
