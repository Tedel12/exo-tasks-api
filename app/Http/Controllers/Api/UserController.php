<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

// Controller pour gérer les membres
// Il utilise le service MemberService pour encapsuler la logique métier
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Fonction pour obtenir tous les membres
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->userService->getAllUsers($perPage);
    }

    // Fonction pour obtenir un membre par son ID
    public function show($id)
    {
        return $this->userService->getUserById($id);
    }

    // Fonction pour créer un membre
    public function store(StoreMemberRequest $request)
    {
        return $this->userService->createUser($request->validated());
    }

    // Fonction pour mettre à jour un membre
    public function update(UpdateMemberRequest $request, $id)
    {
        return $this->userService->updateUser($id, $request->validated());
    }

    // Fonction pour supprimer un membre
    public function destroy($id)
    {
        return $this->userService->deleteUser($id);
    }
}
