<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->postJson("/api/auth/register", [
            "name" => "New Player",
            "email" => "newplayer@example.com",
            "password" => "password123",
            "password_confirmation" => "password123",
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                "message",
                "user" => ["id", "name", "email"],
                "token"
            ]);

        $this->assertDatabaseHas("users", [
            "email" => "newplayer@example.com",
            "name" => "New Player",
        ]);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            "email" => "player@example.com",
            "password" => Hash::make("password123"),
        ]);

        $response = $this->postJson("/api/auth/login", [
            "email" => "player@example.com",
            "password" => "password123",
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "message",
                "user" => ["id", "name", "email"],
                "token"
            ]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        User::factory()->create([
            "email" => "player@example.com",
            "password" => Hash::make("correctpassword"),
        ]);

        $response = $this->postJson("/api/auth/login", [
            "email" => "player@example.com",
            "password" => "wrongpassword",
        ]);

        $response->assertStatus(422);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken("test-token")->plainTextToken;

        $response = $this->withHeaders([
            "Authorization" => "Bearer " . $token,
        ])->postJson("/api/auth/logout");

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_get_profile(): void
    {
        $user = User::factory()->create([
            "name" => "Test Player",
            "email" => "player@example.com",
        ]);
        $token = $user->createToken("test-token")->plainTextToken;

        $response = $this->withHeaders([
            "Authorization" => "Bearer " . $token,
        ])->getJson("/api/auth/me");

        $response->assertStatus(200)
            ->assertJson([
                "user" => [
                    "id" => $user->id,
                    "name" => "Test Player",
                    "email" => "player@example.com",
                ],
            ]);
    }
}
