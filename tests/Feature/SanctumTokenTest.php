<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class SanctumTokenTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sanctum_token_multi_request()
    {
        $user1 = User::factory()->create(['name' => 'user1']);
        $user2 = User::factory()->create(['name' => 'user2']);
         
        $response1 = $this->getJson('/api/user', [
          'Authorization' => "Bearer {$user1->createToken($user1->name)->plainTextToken}"
        ]);
        $response2 = $this->getJson('/api/user', [
          'Authorization' => "Bearer {$user2->createToken($user2->name)->plainTextToken}"
        ]);

        $response1->assertJson([
          'name' => 'user1'
        ]);
        $response2->assertJson([
          'name' => 'user2'
        ]);
    }
}
