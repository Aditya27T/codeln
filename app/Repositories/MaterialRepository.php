<?php
namespace App\Repositories;

use App\Models\Material;

class MaterialRepository
{
    public function all()
    {
        return Material::orderBy('order')->get();
    }
    public function find($id)
    {
        return Material::findOrFail($id);
    }
    public function create(array $data)
    {
        return Material::create($data);
    }
    public function update(Material $material, array $data)
    {
        $material->update($data);
        return $material;
    }
    public function delete(Material $material)
    {
        $material->delete();
    }
}
