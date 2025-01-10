<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\CharacterRepositoryInterface;
use App\Http\Controllers\Api\V1\Resources\CharacterAPIResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CharacterAPIController extends Controller
{
    public function __construct(
        private readonly CharacterRepositoryInterface $characterRepository,
    ) {}

    /**
     * Get characters data for API.
     */
    public function index(): ResourceCollection
    {
        $characters = $this->characterRepository->getAll();
        return CharacterAPIResource::collection($characters);
    }
}
