<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
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

    public function update(array $data, int $id): Model
    {
        $object = $this->getModelById($id);
        $object->update($data);

        return $object;
    }

    public function find(int $id): Model
    {
        return $this->getModelById($id);
    }

    public function delete(int $id): bool
    {
        return $this->getModelById($id)->delete();
    }

    private function getModelById(int $id): Model
    {
        $object = $this->model::find($id);
        if (is_null($object)) {
            throw new NotFoundException(
                (new \ReflectionClass($this->model))->getShortName() . " not found.",
            );
        }

        return $object;
    }
}
