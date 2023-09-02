<?php

namespace App\Repositories;

use App\Contracts\TodoRepositoryInterface;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;


class TodoRepository extends BaseRepository  implements TodoRepositoryInterface
{

    protected $model;

    public function __construct(Todo $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->all();
    }

    public function find(int $id): ?Todo
    {
        return $this->findById($id);
    }

    public function create(array $data): Todo
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->deleteById($id);
    }
}
