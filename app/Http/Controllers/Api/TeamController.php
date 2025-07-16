<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TeamService;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Http\Request;

// Controller pour gérer les équipes
// Il utilise le service TeamService pour encapsuler la logique métier
class TeamController extends Controller
{
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    // Fonction pour obtenir toutes les équipes
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->teamService->getAllTeams($perPage);
    }

    // Fonction pour obtenir une équipe par son ID
    public function show($id)
    {
        return $this->teamService->getTeamById($id);
    }

    // Fonction pour créer une équipe
    public function store(StoreTeamRequest $request)
    {
        return $this->teamService->createTeam($request->validated());
    }

    // Fonction pour mettre à jour une équipe
    public function update(UpdateTeamRequest $request, $id)
    {
        return $this->teamService->updateTeam($id, $request->validated());
    }

    // Fonction pour supprimer une équipe
    public function destroy($id)
    {
        return $this->teamService->deleteTeam($id);
    }
}
