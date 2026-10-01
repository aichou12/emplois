<?php

namespace Tests\Feature;

use Tests\TestCase;

class GuidePageTest extends TestCase
{
    public function test_guide_page_is_public_and_lists_key_sections(): void
    {
        $response = $this->get(route('guide'));

        $response->assertOk();
        $response->assertSee('Guide du candidat');
        $response->assertSee('Documents à préparer');
        $response->assertSee('2 Mo');
        $response->assertSee('4 Mo par fichier');
        $response->assertSee('Questions fréquentes');
    }
}
