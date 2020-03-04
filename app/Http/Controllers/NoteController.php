<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        \Log::info($request->all());
        return response()->noContent();
    }

}
