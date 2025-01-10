<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class CharacterControllerTest extends TestCase
{
    public function testIndexReturnsView(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertViewIs('app');
    }
} 