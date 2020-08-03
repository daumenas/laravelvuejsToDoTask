<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function byId($id);

    public function save($validatedData, $id);

    public function create($validatedData);

    public function delete($id);
}
