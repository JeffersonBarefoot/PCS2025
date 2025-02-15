<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\View\View;

class PositionController extends Controller
{
    /**
     * Show the profile for a given position
     */
    public function show(): View
    {
        return view('positions', [
//            'position' => Position::findOrFail($id)
        ]);
    }
}
