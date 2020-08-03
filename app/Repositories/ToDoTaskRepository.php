<?php
namespace App\Repositories;

use App\ToDoTask;
use App\User;
use App\Repositories\Interfaces\ToDoTaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ToDoTaskRepository implements ToDoTaskRepositoryInterface
{
    public function byId($id)
    {
        $task = ToDoTask::find($id);
        return $task;
    }

    public function allAdmin()
    {
        $tasks = ToDoTask::with('user')->get();
        return $tasks;
    }

    public function allUser($id)
    {
        $tasks = ToDoTask::with('user')->where('user_id', $id)->get();
        return $tasks;
    }

    public function save($validatedData, $id)
    {
        $task = ToDoTask::findOrFail($id);
        if($task) {
            $task->name = $validatedData['name'];
            $task->description = $validatedData['description'];
            $task->status = $validatedData['status'];
            $task->user_id = $validatedData['user_id'];
            $task->created_at = $validatedData['created_at'];

            $task->save();
        }
    }

    public function create($validatedData)
    {
        $task = new ToDoTask();
        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'];
        $task->user_id = $validatedData['user_id'];
        $task->save();
    }

    public function changeStatus($validatedData, $id)
    {
        $task = ToDoTask::findOrFail($id);
        if ($task) {
            $task->status = $validatedData['status'];
            $task->save();
        }
    }

    public function delete($id)
    {
        $task = ToDoTask::findOrFail($id)->delete();
    }
}
