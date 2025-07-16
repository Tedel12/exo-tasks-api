<?php

namespace App\Services;

use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Models\User;
use Illuminate\Support\Str;

// service pour gérer les tâches
// il utilise le modèle Task et la ressource TaskResource pour formater les réponses

class TaskService
{
    // fonction pour obtenir toutes les tâches
    public function getAllTasks($perPage = 10)
    {
        return TaskResource::collection(Task::with(['assignedTo', 'createdBy'])->paginate($perPage));
    }
    // fonction pour obtenir une tâche par son ID
    public function getTaskById($id)
    {
        return new TaskResource(Task::with(['assignedTo', 'createdBy'])->findOrFail($id));
    }

    // fonction pour créer des tâches
    public function createTask(array $data, string $createdById)
    {
        $data['created_by'] = $createdById;

        $task = Task::create([
            'id' => Str::uuid(),
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['due_date'],
            'status' => $data['status'],
            'created_by' => $data['created_by'],
        ]);

        $task->assignedTo()->sync($data['assigned_to']);

        return new TaskResource($task->load(['createdBy', 'assignedTo']));
    }

    // fonction pour mettre à jour une tâche
    public function updateTask($id, array $data)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['due_date'],
            'status' => $data['status'],
            'created_by' => $data['created_by'],
        ]);
        $task->assignedTo()->sync($data['assigned_to']);

        return new TaskResource($task->load(['createdBy', 'assignedTo']));
    }

    // fonction pour supprimer une tâche
    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }


    // fonction pour vérifier si un membre peut gérer une tâche
    // par exemple, un membre peut gérer une tâche s'il est le créateur de la tâche ou s'il a le rôle de manager
     public function canManageTask($userId, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $user = User::find($userId);
        return $user && ($user->role === 'manager' || $task->created_by === $userId);
    }
}