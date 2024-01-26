<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    /** @test */
    public function should_success_health_check(): void
    {
        $response = $this->get('/api/healthz');

        $response->assertStatus(200);
    }
}
