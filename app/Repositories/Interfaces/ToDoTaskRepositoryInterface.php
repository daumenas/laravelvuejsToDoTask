<?php

namespace App\Repositories\Interfaces;

interface ToDoTaskRepositoryInterface
{
    public function byId($id);

    public function save($validatedData, $id);

    public function changeStatus($validatedData, $id);

    public function allAdmin();

    public function allUser($id);

    public function create($validatedData);

    public function delete($id);
}
