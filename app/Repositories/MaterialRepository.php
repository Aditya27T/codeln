<?php
namespace App\Repositories;

use App\Models\Material;

class MaterialRepository
{
    public function all()
    {
        return Material::orderBy('order')->get();
    }

    public function searchAndFilter($search = null)
    {
        $query = Material::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
            });
        }
        return $query->orderBy('order')->get();
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
