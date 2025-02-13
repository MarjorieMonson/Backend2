<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra todos los usuarios en formato JSON.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     * Crea un nuevo usuario con una contraseña generada aleatoriamente.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Str::random(8); // Le colocamos una contraseña por defecto

        $user = User::create($data);

        return response()->json(UserResource::make($user), 201);
    }

    /**
     * Display the specified resource.
     * Muestra un usuario específico.
     */
    public function show(User $user)
    {
        return response()->json(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza los datos de un usuario.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);

        return response()->json(UserResource::make($user));
    }

    /**
     * Remove the specified resource from storage.
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}