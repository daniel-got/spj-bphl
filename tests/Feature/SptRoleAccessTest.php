<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SptRoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('user.spt.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_employee_is_forbidden_to_access_create_spt(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('user.spt.create'));

        $response->assertStatus(403);
    }

    public function test_pembuat_spt_is_allowed_to_access_create_spt(): void
    {
        $user = User::factory()->create([
            'role' => 'pembuat_spt',
        ]);

        $response = $this->actingAs($user)->get(route('user.spt.create'));

        $response->assertStatus(200);
    }

    public function test_admin_is_allowed_to_access_create_spt(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('user.spt.create'));

        $response->assertStatus(200);
    }
}
