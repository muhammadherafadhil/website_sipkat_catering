<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuAdminController extends Controller
{
    public function index()
    {
        return view('admin.menus.index', [
            'menus' => Menu::with('category')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.menus.form', [
            'menu'       => new Menu(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }
        Menu::create($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.form', [
            'menu'       => $menu,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }
        $menu->update($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu dihapus/dinonaktifkan.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name'         => 'required|string|max:150',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]) + ['is_available' => $request->boolean('is_available')];
    }
}