<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;


// Controller pour gérer les tâches
// Il utilise le service TaskService pour encapsuler la logique métier
class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Fonction pour obtenir toutes les tâches
   public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->taskService->getAllTasks($perPage);
    }

    // Fonction pour obtenir une tâche par son ID
    public function show($id)
    {
        return $this->taskService->getTaskById($id);
    }

    // Fonction pour créer une tâche
    public function store(StoreTaskRequest $request)
    {
        if ($request->user()->role !== 'manager') {
        return response()->json(['error' => 'Seuls les managers peuvent créer des tâches.'], 403);
        }

        return $this->taskService->createTask(
            $request->validated(),
            $request->user()->id // on passe l'ID du manager connecté
        );
        }
    // Fonction pour mettre à jour une tâche
     public function update(UpdateTaskRequest $request, $id)
    {
        if (!$this->taskService->canManageTask($request->user()->id, $id)) {
            return response()->json(['error' => 'Seul le manager ayant créé cette tâche peut la modifier ou la supprimer.'], 403);
        }
        return $this->taskService->updateTask($id, $request->validated());
    }


    // Fonction pour supprimer une tâche
    public function destroy(Request $request, $id)
    {
        if (!$this->taskService->canManageTask($request->user()->id, $id)) {
            return response()->json(['error' => 'Seul le manager ayant créé cette tâche peut la modifier ou la supprimer.'], 403);
        }
        return $this->taskService->deleteTask($id);
    }
}
