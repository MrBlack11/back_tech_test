<?php

namespace App\Services;

use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractService
{
    public function __construct(
        private readonly AbstractRepository $repository
    )
    {
    }

    public function list(): Collection
    {
        return $this->repository->list();
    }

    public function create(array $data): Model
    {
        return $this->repository->store($data);
    }

    public function find(int $id): Model
    {
        return $this->repository->find($id);
    }

    public function update(array $data, int $id): Model
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
