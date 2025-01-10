<?php

namespace App\Console\Commands;

use App\Contracts\CharacterServiceInterface;
use App\Exceptions\DuplicateCharacterException;
use App\Exceptions\InvalidPageParamException;
use App\Exceptions\RickAndMortyAPIException;
use Illuminate\Console\Command;

class LoadCharactersCommand extends Command
{
    protected $signature = 'characters:load {page}';
    protected $description = 'Load characters from API and save them in the database';

    public function __construct(private readonly CharacterServiceInterface $characterService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $page = (int) $this->argument('page');
            $this->characterService->verifyPageParam($page);
            $characters = $this->characterService->loadCharacters($page);

            if (!empty($characters)) {
                foreach ($characters as $character) {
                    if ($character['status'] === 'success') {
                        $this->info($character['message']);
                    } else {
                        $this->error($character['message']);
                    }
                }
            }

            return 0;
        } catch (DuplicateCharacterException|InvalidPageParamException|RickAndMortyAPIException $e) {
            $this->error($e->getMessage());
            return 1;
        }
    }
}
