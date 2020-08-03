<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        return response()->json(
            [
                'status' => 'success',
                'users' => $users->toArray()
            ], 200);
    }

    public function show(Request $request, $id)
    {
        $user = $this->userRepository->byId($id);
        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email',
            'name' => '',
            'role' => '',
        ]);
        return $this->userRepository->save($validatedData, $request->id);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        return $this->userRepository->create($validatedData);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }
}
