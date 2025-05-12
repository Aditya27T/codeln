<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Services\MaterialService;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = $this->materialService->all();
        return view('materials.index', compact('materials'));
    }

    public function show($id)
    {
        $material = $this->materialService->find($id);
        // Render markdown ke HTML
        try {
            $converter = new \League\CommonMark\GithubFlavoredMarkdownConverter();
            $contentHtml = $converter->convert($material->content);
        } catch (\Throwable $e) {
            $contentHtml = nl2br(e($material->content));
        }
        return view('materials.show', [
            'material' => $material,
            'contentHtml' => $contentHtml,
        ]);
    }

    // Admin methods
    public function create()
    {
        return view('admin.materials.create');
    }

    protected $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    public function store(StoreMaterialRequest $request)
    {
        $this->materialService->create($request->validated());
        return redirect()->route('admin.materials.index')->with('success', 'Material created successfully');
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $this->materialService->update($material, $request->validated());
        return redirect()->route('admin.materials.index')->with('success', 'Material updated successfully');
    }

    public function destroy(Material $material)
    {
        $this->materialService->delete($material);
        return redirect()->route('admin.materials.index')->with('success', 'Material deleted successfully');
    }
}