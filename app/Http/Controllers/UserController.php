<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index () 
    {
        try {
            return User::consultAllUsers();

        }  catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($idUser) 
    {
        try {
            return User::consultDetailUser($idUser);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(UserCreateRequest $request) 
    {
        try {
            return User::createUser($request);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update (UserUpdateRequest $request, $idUser) 
    {   
        try {
            //Criar formRequest -> Validate
            return User::updateUser($idUser, $request);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function activeUser ($idUser) 
    {
        try {
            return User::activeUser($idUser);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function inactiveUser ($idUser) 
    {
        try {
            return User::inactiveUser($idUser);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($idUser) 
    {
        try {
            return User::deleteUser($idUser);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
