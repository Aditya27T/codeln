<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('order')->get();
        return view('materials.index', compact('materials'));
    }

    public function show(Material $material)
    {
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'order' => 'required|integer',
        ]);

        Material::create($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Material created successfully');
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'order' => 'required|integer',
        ]);

        $material->update($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Material updated successfully');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('admin.materials.index')->with('success', 'Material deleted successfully');
    }
}