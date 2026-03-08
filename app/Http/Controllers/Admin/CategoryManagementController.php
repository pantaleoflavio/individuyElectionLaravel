<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryManagementController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $categoryAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        Category::create($categoryAttributes);

        return redirect()->route('admin.category')->with('success', 'Categoria aggiunta con successo.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.edit-category', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.category.edit', $category->id)->with('success', 'Categoria aggiornata con successo');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.category')->with('success', 'Categoria eliminata con successo');
    }
}