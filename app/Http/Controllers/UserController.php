<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers();
    
        if ($request->expectsJson()) {
            return response()->json(['users' => $users]);
        }
    
        return view('user-form', compact('users'));
    }
    

    public function edit($id)
    {
        $user = $this->userService->getUser($id);
        $users = $this->userService->getAllUsers();
        return view('user-form', compact('user', 'users'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        if ($request->expectsJson()) {
            return response()->json(['user' => $user], 201);
        }

        return redirect('/user-form')->with('success', 'User created successfully!');
    }

    public function update(Request $request, $id)
    {
        $user = $this->userService->updateUser($id, $request->all());

        if ($request->expectsJson()) {
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json(['user' => $user], 200);
        }

        return redirect('/user-form')->with('success', 'User updated successfully!');
    }

    public function show($id)
    {
        $user = $this->userService->getUser($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }

    public function destroy($id, Request $request)
    {
        $user = $this->userService->getUser($id);

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'User not found'], 404);
            } else {    
                return redirect('/user-form')->with('error', 'User not found');
            }
        }
        $user->delete();
        Cache::forget("user_{$id}");
        Cache::forget('users');
        if ($request->expectsJson()) {
            return response()->json(['message' => 'User deleted successfully!']);
        } else {
            return redirect('/user-form')->with('success', 'User deleted successfully!');
        }
    }
}
