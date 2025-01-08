<?php

namespace App\Http\Controllers;

use App\Models\Character;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app');
    }

    /**
     * Get characters data for API.
     */
    public function getCharacters()
    {
        $characters = Character::get();
        return response()->json($characters);
    }
}
