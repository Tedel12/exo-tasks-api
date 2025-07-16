<?php

namespace App\Services;

use App\Models\Team;
use App\Http\Resources\TeamResource;
use Illuminate\Support\Str;


// service pour gérer les équipes
// il utilise le modèle Team et la ressource TeamResource pour formater les réponses
class TeamService
{

    // fonction pour obtener toutes les équipes
    public function getAllTeams($perPage = 10)
    {
        return TeamResource::collection(Team::paginate($perPage));
    }


    // fonction pour obtenir une équipe par son ID
    public function getTeamById($id)
    {
        return new TeamResource(Team::findOrFail($id));
    }

    // fonction pour créer des équipes
    public function createTeam(array $data)
    {
        $team = Team::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
        return new TeamResource($team);
    }


    // fonction pour mettre à jour une équipe
    public function updateTeam($id, array $data)
    {
        $team = Team::findOrFail($id);
        $team->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
        return new TeamResource($team);
    }


    // fonction pour supprimer une équipe
    public function deleteTeam($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return response()->json(['message' => 'Team deleted']);
    }
}