<?php

namespace App\Http\Controllers;

use App\Contracts\CharacterRepositoryInterface;

class CharacterController extends Controller
{
    public function __construct(
        private readonly CharacterRepositoryInterface $characterRepository,
    ) {}

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
        $characters = $this->characterRepository->getAll();
        return response()->json($characters);
    }
}
