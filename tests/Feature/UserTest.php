<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_created_with_address()
    {
        $response = $this->post('/users', [
            'first_name' => 'Cheran',
            'last_name' => 'S',
            'dob' => '1994-06-15',
            'gender' => 'male',
            'addresses' => [
                [
                    'address_type' => 'home',
                    'door_street' => '1st Main Rd',
                    'landmark' => 'Zxy building',
                    'city' => 'Chennai',
                    'state' => 'Tamil Nadu',
                    'country' => 'India',
                ]
            ]
        ]);

        $response->assertStatus(302); // Redirected back
        $this->assertDatabaseHas('users', ['first_name' => 'Cheran']);
        $this->assertDatabaseHas('addresses', ['city' => 'Chennai']);
    }


    /** @test */
    public function api_returns_user_details()
    {
        // First create user
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-14',
            'gender' => 'male',
        ]);

        // Attach address using relationship (recommended)
        $user->addresses()->create([
            'address_type' => 'home',
            'door_street' => '1st Main Rd, Rajiv Nagar',
            'landmark' => 'Zxy building',
            'city' => 'Chennai',
            'state' => 'Tamilnadu',
            'country' => 'India',
        ]);

        // Hit API
        $response = $this->getJson("/api/users/{$user->id}");

        // Assert structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'user_name',
                    'mobile',
                    'dob',
                    'gender',
                    'Address' => [
                        [
                            'address_type',
                            'address1' => [
                                'door/street',
                                'landmark',
                                'city',
                                'state',
                                'country',
                            ],
                            'primary',
                        ]
                    ],
                ]
            ]);
    }


    /** @test */
    public function api_returns_404_for_invalid_user()
    {
        $response = $this->getJson('/api/users/999');

        $response->assertStatus(404)
            ->assertJson([
                'status_code' => 404,
                'message' => 'User not found',
                'data' => null,
            ]);
    }

    /** @test */
    public function user_validation_fails_without_required_fields()
    {
        $response = $this->post('/users', []);

        $response->assertSessionHasErrors(['first_name', 'dob', 'gender', 'addresses']);
    }
}
