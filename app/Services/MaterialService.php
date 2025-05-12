<?php
namespace App\Services;

use App\Models\Material;

class MaterialService
{
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
