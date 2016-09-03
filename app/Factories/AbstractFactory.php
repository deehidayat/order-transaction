<?php
namespace App\Factories;

use Illuminate\Http\Request;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractFactory implements ICRUDFactory
{
    protected $model;

    abstract protected function getModelClass();

    abstract public function getFilterAttributes();

    abstract public function validateCreateRequest(Array $data);

    abstract public function validateUpdateRequest(Array $data, $id);

    function __construct(Application $app) {
        $this->app = $app;
        $this->makeModel();
    }
    
    protected function makeModel() 
    {
        $model = $this->app->make($this->getModelClass());
        return $this->model = $model;
    }

    public function getTotal()
    {
        return $this->model->count();
    }

    public function search(Request $request)
    {
        $attributes = $this->getFilterAttributes();
        $result = $this->model->all();
        $queries = empty($request->input('filter')) ? [] : json_decode($request->input('filter'));
        foreach ($queries as $key => $query) {
            if (array_search($key, $attributes) !== -1) {
                $result = $result->where($key, $query);
            }
        }
        return $result;
    }

    public function find($id)
    {
        $record = $this->model->find($id);
        if (!empty($record)) {
            return $record;
        } else {
            throw new \Exception('Record Not Found');
        }
    }

    public function create(Request $request)
    {
        $data = $request->input();

        $this->validateCreateRequest($data);

        $record = $this->model->create($data);
        if (!empty($record)) {
            return $record;
        } else {
            throw new \Exception('Failed To Create Record');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->input();

        $this->validateUpdateRequest($data, $id);

        $record = $this->model->find($id);
        if (!empty($record)) {
            $record->update($data);
            return $record;
        } else {
            throw new \Exception('Record Not Found');
        }
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        if (!empty($record)) {
            return $record->delete();
        } else {
            throw new \Exception('Record Not Found');
        }
    }
}