<?php
namespace App\Factories;

use Illuminate\Http\Request;

interface ICRUDFactory 
{
    public function getTotal();

    public function search(Request $request);

    public function find($id);

    public function create(Request $data);

    public function update(Request $data, $id);

    public function delete($id);
}