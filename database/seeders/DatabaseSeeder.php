<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Créer 10 utilisateurs avec des rôles différents
        $users = User::factory()->count(10)->create();


        // verifier que users contients des donnees
        if ($users->isEmpty()) {
            throw new \Exception('No users created. Please check the UserFactory.');
        }

        // Créer 10 équipes
        $teams = Team::factory()->count(10)->create();

        // Associer les users aux équipes aléatoirement
        foreach ($teams as $team) {
            $teamUsers = $users->random(3)->pluck('id')->all(); // Récupère les UUIDs
            $team->users()->syncWithoutDetaching($teamUsers); // 3 users par équipe
        }

        // Créer 10 tâches
        $tasks = Task::factory()->count(10)->create();

        // Associer des tâches aux membres
        foreach ($tasks as $task) {
            $taskUsers = $users->where('role', '!=', 'manager')->random(2)->pluck('id')->all(); // 2 membres par tâche
            $task->users()->syncWithoutDetaching($taskUsers);
        }
    }
}