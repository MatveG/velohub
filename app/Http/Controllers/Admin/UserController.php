<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::get([
            'id',
            'is_active',
            'name',
            'email',
            'created_at'
        ]);

        return response()->json($users);
    }

    public function get($id): JsonResponse
    {
        $user = User::findOrFail($id)->append(['imagesPath']);

        return response()->json($user);
    }

    public function post(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email'
        ]);

        $user = User::create($request->all());

        return response()->json($user);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        $changed = array_keys($user->getChanges());

        return response()->json($user->only($changed));
    }

    public function delete(int $id): JsonResponse
    {
        User::findOrFail($id)->delete();

        return response()->json(compact('id'));
    }
}
