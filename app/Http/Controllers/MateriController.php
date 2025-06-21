<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index()
    {
        $materis = \App\Models\Materi::orderByDesc('date')->get();
        return view('materi.index', compact('materis'));
    }

}
