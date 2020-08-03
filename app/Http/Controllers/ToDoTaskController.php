<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ToDoTaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoTaskController extends Controller
{
    private $toDoTaskRepository;

    public function __construct(ToDoTaskRepositoryInterface $toDoTaskRepository)
    {
        $this->toDoTaskRepository = $toDoTaskRepository;
    }

    public function indexAdmin()
    {
        $tasks = $this->toDoTaskRepository->allAdmin();
        return response()->json(
            [
                'status' => 'success',
                'tasks' => $tasks->toArray()
            ], 200);
    }

    public function indexUser()
    {
        $id = Auth::id();
        $tasks = $this->toDoTaskRepository->allUser($id);
        return response()->json(
            [
                'status' => 'success',
                'tasks' => $tasks->toArray()
            ], 200);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => '',
            'description' => '',
            'status' => 'required',
            'user_id' => '',
            'created_at' => ''
        ]);
        return $this->toDoTaskRepository->save($validatedData, $request->id);
    }

    public function changeStatus(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required',
        ]);
        return $this->toDoTaskRepository->changeStatus($validatedData, $request->id);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'user_id' => ''
        ]);
        return $this->toDoTaskRepository->create($validatedData);
    }

    public function delete($id)
    {
        return $this->toDoTaskRepository->delete($id);
    }
}
