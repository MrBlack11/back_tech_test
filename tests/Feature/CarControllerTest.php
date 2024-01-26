<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function should_create_car(): void
    {
        $payload = Car::factory()->make()->toArray();

        $this->post("/api/cars", $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('cars', $payload);
    }

    /** @test */
    public function should_not_create_without_required_fields(): void
    {
        $payload = Car::factory()->make()->toArray();

        $fieldMissingPayload = $payload;
        unset($fieldMissingPayload['brand']);

        $this->post("/api/cars", $fieldMissingPayload)
            ->assertStatus(422);

        $this->assertDatabaseMissing('cars', $payload);
    }

    /** @test */
    public function should_list_cars(): void
    {
        $createdCars = Car::factory(3)->create();

        $response = $this->get('/api/cars');
        $response->assertStatus(200);

        $this->assertCount($createdCars->count(), json_decode($response->content()));
    }

    /** @test */
    public function should_delete_car(): void
    {
        $createdCar = Car::factory()->create();

        $this->delete("/api/cars/" . $createdCar->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing("cars", ['id' => $createdCar->id]);
    }

    /** @test */
    public function should_not_delete_car_passing_wrong_car_id(): void
    {
        $this->delete("/api/cars/1")
            ->assertStatus(404)
            ->assertJson(['message' => 'Car not found.']);
    }

    /** @test */
    public function should_retrieve_car_passing_id(): void
    {
        $createdCar = Car::factory()->create();

        $this->get("/api/cars/" . $createdCar->id)
            ->assertStatus(200);
    }

    /** @test */
    public function should_not_retrieve_car_passing_wrong_id(): void
    {
        $this->get("/api/cars/1")
            ->assertStatus(404)
            ->assertJson(['message' => 'Car not found.']);
    }

    /** @test */
    public function should_update_car(): void
    {
        $createdCar = Car::factory()->create();

        $payload = [
            "brand" => "new brand",
            "model" => "model test"
        ];

        $this->put("/api/cars/" . $createdCar->id, $payload)
            ->assertStatus(200);

        $this->assertDatabaseHas("cars", $payload);
    }

    /** @test */
    public function should_not_update_car_with_non_created_car_id(): void
    {
        $payload = [
            "renavam" => $this->faker->text(10),
        ];

        $this->put("/api/cars/1", $payload)
            ->assertStatus(404)
            ->assertJson(['message' => 'Car not found.']);
    }

    /** @test */
    public function should_not_update_car_with_wrong_fields(): void
    {
        $createdCar = Car::factory()->create();

        $payload = [
            "brand" => "revanam out of char limit",
        ];

        $this->put("/api/cars/" . $createdCar->id, $payload)
            ->assertStatus(422);
    }
}
