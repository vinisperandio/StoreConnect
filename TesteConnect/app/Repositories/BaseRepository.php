<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class BaseRepository implements BaseRepositoryInterface
{
    // class to be used to define model must be defined at subclasses
    protected $modelClass;
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct()
    {
        //Create model instance from model class defined by the subclass repository
        $this->makeModel();
    }

    /**
     * Create model instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws Exception
     */
    private function makeModel()
    {
        if (!$this->modelClass) {
            throw new Exception("The model class must be set on the repository.");
        }
        return $this->model = with(new $this->modelClass);
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // find the record with the given id
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    //find the record that satisfact the condition given
    public function where($fieldname, $value, $condition = null)
    {
        if($condition)
            return $this->model->where($fieldname, $condition, $value);
        else
        return $this->model->where($fieldname, $value);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
