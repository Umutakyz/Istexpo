<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Fair;

class DashboardController extends Controller
{
    public function index()
    {
        $fairCount = Fair::count();
        $representationCount = \App\Models\Representation::count();
        $recentFairs = Fair::latest()->take(5)->get();

        return view('admin.dashboard', compact('fairCount', 'representationCount', 'recentFairs'));
    }
}
