<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Trener extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $roles = Role::where('name', 'trainer')->first();
        $trainers = $roles->users;
        return view('trainers.index', compact('trainers'));
    }
}
