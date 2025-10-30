<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get a new query builder instance
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * Find a record by ID
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find a record by ID or fail
     */
    public function findByIdOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Store a new record
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record
     */
    public function update($id, array $data)
    {
        $record = $this->findById($id);

        if ($record) {
            $record->update($data);

            return $record;
        }

        return null;
    }

    /**
     * Delete a record
     */
    public function delete($id)
    {
        $record = $this->findById($id);

        if ($record) {
            return $record->delete();
        }

        return false;
    }

    /**
     * Get all records
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Paginate records
     */
    public function paginate($perPage = 15)
    {
        return $this->model->paginate($perPage);
    }
}
