<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function should_list_users(): void
    {
        $createdUsers = User::factory(3)->create();

        $response = $this->get('/api/users');

        $response->assertStatus(200);

        $listUsersData = json_decode($response->content());

        $this->assertCount($createdUsers->count(), $listUsersData);
    }

    /** @test */
    public function should_create_user(): void
    {
        $payload = [
            "email" => $this->faker->email,
            "password" => $this->faker->password,
            "name" => $this->faker->name
        ];

        $createResponse = $this->post("/api/users", $payload);
        $createResponse->assertStatus(201);

        unset($payload['password']);
        $this->assertDatabaseHas("users", $payload);
    }

    /** @test */
    public function should_not_create_user_with_duplicated_email(): void
    {
        $createdUser = User::factory()->create([
            "email" => $this->faker->email
        ]);

        $payload = [
            "email" => $createdUser->email,
            "password" => $this->faker->password,
            "name" => $this->faker->name
        ];

        $createResponse = $this->post("/api/users", $payload);
        $createResponse->assertStatus(422);

        $this->assertDatabaseCount("users", 1);
    }

    /** @test */
    public function should_not_create_user_without_required_fields()
    {
        $payload = [ // missing email
            "password" => $this->faker->password,
            "name" => $this->faker->name
        ];

        $createResponse = $this->post("/api/users", $payload);
        $createResponse->assertStatus(422);

        $this->assertDatabaseCount("users", 0);
    }

    /** @test */
    public function should_not_create_user_without_wrong_fields()
    {
        $payload = [
            "email" => $this->faker->email,
            "password" => '12345',
            "name" => $this->faker->name
        ];

        $createResponse = $this->post("/api/users", $payload);
        $createResponse->assertStatus(422);

        $this->assertDatabaseCount("users", 0);
    }
}
