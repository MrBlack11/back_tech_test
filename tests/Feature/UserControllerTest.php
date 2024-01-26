<?php

namespace Tests\Feature;

use App\Models\Car;
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

        $this->assertCount($createdUsers->count(), json_decode($response->content()));
    }

    /** @test */
    public function should_create_user(): void
    {
        $payload = [
            "email" => $this->faker->email,
            "password" => $this->faker->password,
            "name" => $this->faker->name
        ];

        $this->post("/api/users", $payload)
            ->assertStatus(201);

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
    public function should_not_create_user_without_required_fields(): void
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
    public function should_not_create_user_without_wrong_fields(): void
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

    /** @test */
    public function should_update_user(): void
    {
        $createdUser = User::factory()->create();

        $payload = [
            "email" => $this->faker->email,
            "password" => $this->faker->password,
            "name" => $this->faker->name
        ];

        $createResponse = $this->put("/api/users/" . $createdUser->id, $payload);
        $createResponse->assertStatus(200);

        unset($payload['password']);
        $this->assertDatabaseHas("users", $payload);
    }

    /** @test */
    public function should_update_user_sending_same_email(): void
    {
        $this->markTestSkipped("need to cover same email updating, when add auth");
        $createdUser = User::factory()->create();

        $payload = [
            "email" => $createdUser->email,
            "name" => $this->faker->name
        ];

        $createResponse = $this->put("/api/users/" . $createdUser->id, $payload);
        $createResponse->assertStatus(200);

        $this->assertDatabaseHas("users", $payload);
    }

    /** @test */
    public function should_not_update_user_with_duplicated_email(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $payload = [
            "email" => $secondUser->email,
        ];

        $this->put("/api/users/" . $firstUser->id, $payload)->assertStatus(422);
    }

    /** @test */
    public function should_not_update_user_with_non_created_user_id(): void
    {
        $payload = [
            "email" => $this->faker->email,
        ];

        $this->put("/api/users/1", $payload)
            ->assertStatus(404)
            ->assertJson(['message' => 'User not found.']);
    }

    /** @test */
    public function should_delete_user(): void
    {
        $createdUser = User::factory()->create();

        $this->delete("/api/users/" . $createdUser->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing("users", ['id' => $createdUser->id]);
    }

    /** @test */
    public function should_not_delete_user_passing_wrong_user_id(): void
    {
        $this->delete("/api/users/1")
            ->assertStatus(404)
            ->assertJson(['message' => 'User not found.']);
    }

    /** @test */
    public function should_retrieve_user_passing_id(): void
    {
        $createdUser = User::factory()->create();

        $this->get("/api/users/" . $createdUser->id)
            ->assertStatus(200);
    }

    /** @test */
    public function should_not_retrieve_user_passing_wrong_id(): void
    {
        $this->get("/api/users/1")
            ->assertStatus(404)
            ->assertJson(['message' => 'User not found.']);
    }

    /** @test */
    public function should_relate_user_and_car(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $payload = [
            'car_id' => $car->id
        ];

        $this->post("/api/users/" . $user->id . "/cars", $payload)
            ->assertStatus(200);

        $this->assertDatabaseHas(
            'user_cars',
            array_merge(['user_id' => $user->id], $payload)
        );
    }

    /** @test */
    public function should_not_relate_user_and_car_twice(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $payload = [
            'car_id' => $car->id
        ];

        $this->post("/api/users/" . $user->id . "/cars", $payload)
            ->assertStatus(200);

        $this->post("/api/users/" . $user->id . "/cars", $payload)
            ->assertStatus(400)
            ->assertJson(["message" => "The relation already exists."]);
    }

    /** @test */
    public function should_remove_car_from_user(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $payload = [
            'car_id' => $car->id
        ];

        $this->post("/api/users/" . $user->id . "/cars", $payload)
            ->assertStatus(200);

        $this->delete("/api/users/" . $user->id . "/cars/" . $car->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing(
            'user_cars',
            array_merge(['user_id' => $user->id], $payload)
        );
    }

    /** @test */
    public function should_remove_car_from_user_when_relation_not_exists(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $this->delete("/api/users/" . $user->id . "/cars/" . $car->id)
            ->assertStatus(404);
    }

    /** @test */
    public function should_list_user_cars(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $payload = [
            'car_id' => $car->id
        ];

        $this->post("/api/users/" . $user->id . "/cars", $payload)
            ->assertStatus(200);

        $this->get("/api/users/" . $user->id . "/cars")
            ->assertStatus(200)
            ->assertJsonStructure([
                "current_page",
                "data",
                "first_page_url",
                "from",
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to"
            ]);
    }

}
