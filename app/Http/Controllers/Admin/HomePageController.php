<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgeGroup;

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
        });

        // Age groups have their own admin page (not part of the generic home_content types)
        $widgets->push([
            'title'       => 'Age Groups',
            'description' => 'Shop by Age cards, shop filter, menus and footer. Range, name, icon and color.',
            'icon'        => 'fa-child',
            'tone'        => 'wi-amber',
            'count'       => AgeGroup::count(),
            'manage'      => route('admin.home.age-groups.index'),
            'create'      => route('admin.home.age-groups.index', ['new' => 1]),
        ]);

        $widgets = $widgets->values();

        return view('admin.home.index', compact('widgets'));
    }
}