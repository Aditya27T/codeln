<?php
namespace App\Services;

use App\Models\Material;
use App\Repositories\MaterialRepository;

class MaterialService
{
    protected $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }
    public function create(array $data)
    {
        return $this->materialRepository->create($data);
    }
    public function update(Material $material, array $data)
    {
        return $this->materialRepository->update($material, $data);
    }
    public function delete(Material $material)
    {
        return $this->materialRepository->delete($material);
    }
    public function all()
    {
        return $this->materialRepository->all();
    }
    public function find($id)
    {
        return $this->materialRepository->find($id);
    }
}
