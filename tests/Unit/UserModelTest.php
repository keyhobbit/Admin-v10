<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create([
            "name" => "Test User",
            "email" => "test@example.com",
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals("Test User", $user->name);
        $this->assertEquals("test@example.com", $user->email);
    }

    public function test_user_can_create_api_tokens(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken("test-token");

        $this->assertNotNull($token);
        $this->assertNotEmpty($token->plainTextToken);
    }

    public function test_user_can_have_multiple_tokens(): void
    {
        $user = User::factory()->create();

        $token1 = $user->createToken("token-1");
        $token2 = $user->createToken("token-2");

        $this->assertCount(2, $user->tokens);
        $this->assertNotEquals($token1->plainTextToken, $token2->plainTextToken);
    }

    public function test_user_tokens_can_be_revoked(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken("test-token");

        $this->assertCount(1, $user->fresh()->tokens);

        $user->tokens()->delete();

        $this->assertCount(0, $user->fresh()->tokens);
    }
}
