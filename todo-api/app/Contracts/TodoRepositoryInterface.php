<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Todo;

interface TodoRepositoryInterface
{
    public function getAll(): Collection;

    public function find(int $id): ?Todo;

    public function create(array $data): Todo;

    public function update(int $id, array $data): bool;

    public function delete($id): bool;
}
