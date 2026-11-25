<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        // PRD 4.1: beranda menampilkan identitas, layanan, menu unggulan
        $featured = Menu::available()->latest()->take(6)->get();
        $stats = [
            'menus'      => Menu::available()->count(),
            'categories' => \App\Models\Category::active()->count(),
        ];
        return view('home', compact('featured', 'stats'));
    }
}