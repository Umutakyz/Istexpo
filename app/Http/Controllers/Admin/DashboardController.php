<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Fair;
use App\Models\Sector;

class DashboardController extends Controller
{
    public function index()
    {
        $fairCount = Fair::count();
        $sectorCount = Sector::count();
        $recentFairs = Fair::with('sector')->latest()->take(5)->get();

        return view('admin.dashboard', compact('fairCount', 'sectorCount', 'recentFairs'));
    }
}
