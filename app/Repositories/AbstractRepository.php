<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    public function __construct(
        private readonly Model $model
    )
    {
    }

    public function store(array $data): Model
    {
        return $this->model::create($data);
    }

    public function list(): Collection
    {
        return $this->model::all();
    }

    public function update(array $data, int $id): bool
    {
        return $this->model::where('id', $id)->update($data);
    }

    public function find(int $id): Model | null
    {
        return $this->model::find($id);
    }

    public function delete(int $id): bool
    {
        return $this->model::find($id)->delete();
    }
}
