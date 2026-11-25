<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // PRD 4.1: katalog — hanya menu aktif & kategori aktif
    public function index(Request $request)
    {
        $query = Menu::available()->with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $menus      = $query->paginate(12)->withQueryString();
        $categories = Category::active()->get();

        return view('menu.index', compact('menus', 'categories'));
    }

    public function show(Menu $menu)
    {
        // menu nonaktif tidak bisa diakses
        abort_unless($menu->isPurchasable(), 404);
        return view('menu.show', compact('menu'));
    }
}