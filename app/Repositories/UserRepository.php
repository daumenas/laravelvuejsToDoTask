<?php
namespace App\Repositories;

use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function byId($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function all()
    {
        $users = User::with('tasks')->get();
        return $users;
    }

    public function save($validatedData, $id)
    {
        $user = User::findOrFail($id);
        if($user) {
            $user->email = $validatedData['email'];
            $user->password = $validatedData['role'];
            $user->name = $validatedData['name'];

            $user->save();
        }
    }

    public function create($validatedData)
    {
        $user = new User();
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];
        $user->save();
    }

    public function delete($id)
    {
        return User::findOrFail($id)->delete();
    }
}
