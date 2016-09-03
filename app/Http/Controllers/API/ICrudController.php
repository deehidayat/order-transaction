<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

interface ICrudController
{
    public function index(Request $request);

    public function store(Request $request);

    public function show(Request $request, $id);

    public function update(Request $request, $id);

    public function delete(Request $request, $id);
}