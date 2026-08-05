<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_optional_public_sections_render_when_their_data_source_is_unavailable(): void
    {
        foreach (['/documentosdegestionweb', '/infraestructuraall', '/infraestructura-galeria', '/resoluciones'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('id="dre-chatbot"', false);
        }
    }
}
