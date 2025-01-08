<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $characters = DB::table('characters')->get();
        return response()->json($characters);
    }
}
