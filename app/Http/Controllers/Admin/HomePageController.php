<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index()
    {
        $widgets = collect(config('home_content.types'))->map(function ($cfg, $type) {
            return [
                'title'       => $cfg['title'],
                'description' => $cfg['description'],
                'icon'        => $cfg['icon'],
                'tone'        => $cfg['tone'],
                'count'       => $cfg['model']::count(),
                'manage'      => route('admin.home.content.index', $type),
                'create'      => route('admin.home.content.create', $type),
            ];
        })->values();

        return view('admin.home.index', compact('widgets'));
    }
}