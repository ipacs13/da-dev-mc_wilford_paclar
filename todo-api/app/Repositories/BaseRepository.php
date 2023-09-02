<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function getAllWhereHas($whereHas, $subQuery, array $relations = [], string $orderBy = 'asc'): Collection
    {
        return $this->model->whereHas(
            $whereHas,
            $subQuery
        )
            ->with($relations)
            ->orderBy('created_at', $orderBy)
            ->get();
    }

    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model
            ->when(!empty($columns), fn ($query) => $query->select($columns))
            ->when(!empty($relations), fn ($query) => $query->with($relations))
            ->find($modelId);
    }

    public function findTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model->fresh();
    }

    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);

        return $model->update($payload);
    }

    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }

    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->findTrashedById($modelId)->delete();
    }
}
