<?php

namespace app\controllers;
use app\models\DolibarrModel;
use app\models\DemandeTicketModel;
use app\models\AgentModel;
use app\models\ClientModel;
use app\models\RealisationModel;
use app\models\PrevisionModel;
use app\models\DemandeFinanceModel;
use DateTime;
use Exception;
use Flight;

class TicketController
{

    public function __construct()
    {

    }
    public function ajouter_realisation($montant)
    {
        $date = date('Y-m-d');

        $realisationModel = new RealisationModel(Flight::db());
        $previsionModel = new PrevisionModel(Flight::db());
        $demandeFinanceModel = new DemandeFinanceModel(Flight::db());

        if ($montant === null) {
            return ['success' => false, 'error' => 'Données manquantes'];
        }

        try {
            $prevision = $previsionModel->getByDate2($date);
            $montant2 = $prevision['montant'] ?? 0;

            if ($montant > $montant2) {
                $demandeFinanceModel->create($date, NULL, $montant - $montant2);
                return ['success' => true, 'message' => 'Demande de financement générée.'];
            } else {
                $success = $realisationModel->create($date, $montant, 1, 1, 6);
                if ($success) {
                    return ['success' => true, 'message' => 'Réalisation enregistrée.'];
                } else {
                    return ['success' => false, 'error' => 'Erreur lors de l’enregistrement.'];
                }
            }

        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    public function findAll()
    {
        $dolibarrModel = new DolibarrModel();
        $clientModel = new ClientModel(Flight::db());
        $agentModel = new AgentModel(Flight::db());
        $tickets = $dolibarrModel->findAllTickets();

        if (!$tickets) {
            $tickets = [];
        }

        $data = [
            'page' => 'tickets',
            'tickets' => $tickets,
            'clients' => $clientModel->findAll(),
            'agents' => $agentModel->findAll(),
            'statut' => Flight::get('statut')
        ];

        Flight::render('admin/template.php', $data);
    }
    public function findTicketsByExternalUserId()
    {
        $dolibarrModel = new DolibarrModel();
        $agentModel = new AgentModel(Flight::db());
        $agents = $agentModel->findAll();
        $tickets = $dolibarrModel->findTicketsByExternalUserId(Flight::session('id_client'));

        if (!$tickets) {
            $tickets = [];
        }

        $data = [
            'page' => 'tickets',
            'tickets' => $tickets,
            'agents' => $agents,
            'statut' => Flight::get('statut')
        ];

        Flight::render('client/template.php', $data);
    }

    public function findTicketsByExternalAgentId()
    {
        $dolibarrModel = new DolibarrModel();
        $agentModel = new AgentModel(Flight::db());
        $clientModel = new ClientModel(Flight::db());
        $agents = $agentModel->findAll();
        $clients = $clientModel->findAll();
        $tickets = $dolibarrModel->findTicketsByExternalAgentId(Flight::session('id_agent'));

        if (!$tickets) {
            $tickets = [];
        }

        $data = [
            'page' => 'tickets',
            'tickets' => $tickets,
            'agents' => $agents,
            'clients' => $clients,
            'statut' => Flight::get('statut')
        ];

        Flight::render('commercial/tickets.php', $data);
    }

    public function form()
    {
        // Vérification si l'utilisateur est connecté
        if (!Flight::session('id_admin')) {
            Flight::redirect('login?error=Veuillez vous connecter pour créer une demande');
            return;
        }

        $demandeTicket = new DemandeTicketModel(Flight::db());
        $agentModel = new AgentModel(Flight::db());

        // Récupération de la liste des agents
        $agents = $agentModel->findAll();
        $id = Flight::request()->query['id'] ?? null;

        $demande = $demandeTicket->findById($id);

        $data = [
            'page' => 'form',
            'demande' => $demande,
            'agents' => $agents
        ];
        Flight::render('admin/template.php', $data);

    }

    public function create()
    {
        $data = Flight::request()->data;

        $severityMap = Flight::get('severityMap');
        $typesMap = Flight::get('ticketTypeMap');
        $categoriesMap = Flight::get('ticketCategoryMap');

        $id_demande = $data['id_demande'] ?? null;
        $id_client = $data['id_client'] ?? null;
        $subject = $data['subject'] ?? null;
        $messageContent = $data['message'] ?? null;
        $id_agent = $data['id_agent'] ?? null;
        $severity = $data['severity'] ?? 'normale';
        $type = $data['type'] ?? null;
        $categorie = $data['categorie'] ?? null;

        // Vérification des champs requis
        if (empty($subject) || empty($messageContent)) {
            Flight::redirect('create_demande?error=Tous les champs sont requis');
            return;
        }

        $dolibarrModel = new DolibarrModel();
        $demandeTicketModel = new DemandeTicketModel(Flight::db());

        $ticketData = [
            'subject' => $subject,
            'message' => $messageContent,
            'severity_code' => $severityMap[$severity]['code'] ?? 'NORMAL',
            'severity_label' => $severityMap[$severity]['label'] ?? 'Normal',
            'type_code' => $typesMap[$type]['code'] ?? 'OTHER',
            'type_label' => $typesMap[$type]['label'] ?? 'Other',
            'category_code' => $categoriesMap[$categorie]['code'] ?? 'OTHER',
            'category_label' => $categoriesMap[$categorie]['label'] ?? 'Other',
            'array_options' => [
                'options_userid_external' => $id_client,
                'options_agentid_external' => $id_agent,
                'options_date_creation' => date('Y-m-d H:i:s'),
            ],
        ];


        try {
            $success = $dolibarrModel->createDolibarrTicket($ticketData);
            if (isset($success['error'])) {
                throw new Exception($success['error']);
            }
            $success1 = $demandeTicketModel->updateStatus($id_demande, $success['ticket_id']);
            if ($success1) {
                Flight::redirect(BASE_URL . '/admin/demandes?success=Ticket créé avec succès');
            } else {
                Flight::redirect(BASE_URL . '/admin/demandes?error=Erreur lors de la création du ticket');
            }
        } catch (Exception $e) {
            Flight::redirect(BASE_URL . '/admin/demandes?error=' . urlencode($e->getMessage()));
        }
    }

    public function refuser()
    {
        $id = Flight::request()->query['id'] ?? null;

        if (empty($id)) {
            Flight::redirect(BASE_URL . '/admin/demandes?error=ID de la demande manquant');
            return;
        }

        $demandeTicketModel = new DemandeTicketModel(Flight::db());
        $success = $demandeTicketModel->refuse($id);

        if ($success) {
            Flight::redirect(BASE_URL . '/admin/demandes?success=Demande refusée avec succès');
        } else {
            Flight::redirect(BASE_URL . '/admin/demandes?error=Erreur lors du refus de la demande');
        }
    }

    public function update()
    {
        $ticketId = $_POST['id'] ?? null;
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';
        $fk_statut = $_POST['fk_statut'] ?? null;
        $dolibarrModel = new DolibarrModel();
        $agentModel = new AgentModel(Flight::db());

        if (!$ticketId) {
            echo json_encode(['success' => false, 'error' => 'ID manquant']);
            return;
        }
        if ($fk_statut == 5 || $fk_statut == 6) {
            $date_fin = date('Y-m-d H:i:s');
            $result = $dolibarrModel->updateDolibarrTicket($ticketId, [
                'subject' => $subject,
                'message' => $message,
                'status' => $fk_statut,
                'array_options' => [
                    'options_date_fin' => $date_fin,
                ],
            ]);
            if ($fk_statut == 5) {
                $ticket = $dolibarrModel->getDolibarrTicket($ticketId);
                $agent = $agentModel->findById($ticket['array_options']['options_agentid_external']);
                $date_debut = $ticket['array_options']['options_date_creation'] ?? null;
                if ($date_debut && isset($agent['tarif'])) {
                    if (is_numeric($date_debut)) {
                        $date_debut = date('Y-m-d H:i:s', $date_debut);
                    }
                    $datetime1 = new DateTime($date_debut);
                    $datetime2 = new DateTime($date_fin);
                    $interval = $datetime1->diff($datetime2);
                    $hours = $interval->days * 24 + $interval->h + $interval->i / 60;
                    $money = $hours * $agent['tarif'];
                    $test = $this->ajouter_realisation($money);
                    if (isset($test['error'])) {
                        echo json_encode(['success' => false, 'error' => $test['error']]);
                    }
                }
            }
            if (isset($result['error'])) {
                echo json_encode(['success' => false, 'error' => $result['error']]);
            } else {
                echo json_encode(['success' => true]);
            }
        } else {
            $result = $dolibarrModel->updateDolibarrTicket($ticketId, [
                'subject' => $subject,
                'message' => $message,
                'status' => $fk_statut,
                'array_options' => [
                    'options_date_fin' => date('Y-m-d H:i:s'),
                ],
            ]);
            if (isset($result['error'])) {
                echo json_encode(['success' => false, 'error' => $result['error']]);
            } else {
                echo json_encode(['success' => true]);
            }
        }



    }


}