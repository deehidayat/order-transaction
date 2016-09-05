<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

abstract class AbstractController implements ICrudController
{
    protected $factory;

    protected function response($data, $code = 200) 
    {
        return response()->json($data, $code, [], JSON_NUMERIC_CHECK);
    }

    public function index(Request $request) {
        return $this->response([
            'data' => $this->factory->search($request)
        ]);
    }

    public function show(Request $request, $id) {
        try {
            $record = $this->factory->find($id);
        } catch (\Exception $e) {
            return $this->response([
                'error' => json_decode($e->getMessage()) ? json_decode($e->getMessage()) : $e->getMessage()
            ]);    
        }
        return $this->response([
            'id' => $id,
            'data' => $record
        ]);
    }

    public function store(Request $request) {
        try {
            $record = $this->factory->create($request);
        } catch (\Exception $e) {
            return $this->response([
                'error' => json_decode($e->getMessage()) ? json_decode($e->getMessage()) : $e->getMessage()
            ]);    
        }
        return $this->response([
            'data' => $record,
            'success' => true
        ]);
    }

    public function update(Request $request, $id) {
        try {
            $record = $this->factory->update($request, $id);
        } catch (\Exception $e) {
            return $this->response([
                'error' => json_decode($e->getMessage()) ? json_decode($e->getMessage()) : $e->getMessage()
            ]);    
        }
        return $this->response([
            'id' => $id,
            'data' => $record,
            'success' => true
        ]);
    }

    public function delete(Request $request, $id) {
        try {
            $record = $this->factory->delete($id);
        } catch (\Exception $e) {
            return $this->response([
                'error' => json_decode($e->getMessage()) ? json_decode($e->getMessage()) : $e->getMessage()
            ]);    
        }
        return $this->response([
            'id' => $id,
            'success' => true
        ]);
    }
}
