<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

// service pour gérer les membres
// il utilise le modèle Member et la ressource MemberResource pour formater les réponses

class UserService
{

    // fonction pour obtenir tous les membres
    public function getAllUsers($perPage = 10)
    {
        return UserResource::collection(User::paginate($perPage));
    }

    // fonction pour obtenir un membre par son ID
    public function getUserById($id)
    {
        return new UserResource(User::with('teams')->findOrFail($id));
    }

    // fonction pour créer des membres
    public function createUser(array $data)
    {
        // Création d'un utilisateur avec 'name' au lieu de first_name et last_name
        $user = User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'] ?? 'defaultpassword'),
            'role' => $data['role'],
            'email_verified_at' => now(),
        ]);

        // Gestion des équipes si fournies
        if (isset($data['team_ids']) && is_array($data['team_ids'])) {
            $user->teams()->sync($data['team_ids']);
        }

        return new UserResource($user->load('teams'));
    }

    // fonction pour mettre à jour un membre
    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            // Tu peux aussi gérer le password ici si besoin
            'role' => $data['role'],
        ]);

        if (isset($data['team_ids']) && is_array($data['team_ids'])) {
            $user->teams()->sync($data['team_ids']);
        }

        return new UserResource($user->load('teams'));
    }

    // fonction pour supprimer un membre
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}