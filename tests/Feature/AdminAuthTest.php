<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can view login page
     */
    public function test_admin_can_view_login_page(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.auth.login');
        $response->assertSee('Admin Login');
    }

    /**
     * Test admin can login with valid credentials
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        // Create admin with known password
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    /**
     * Test admin cannot login with invalid password
     */
    public function test_admin_cannot_login_with_invalid_password(): void
    {
        Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('admin');
    }

    /**
     * Test admin cannot login with non-existent email
     */
    public function test_admin_cannot_login_with_nonexistent_email(): void
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('admin');
    }

    /**
     * Test admin login requires email
     */
    public function test_admin_login_requires_email(): void
    {
        $response = $this->post(route('admin.login'), [
            'password' => 'admin123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test admin login requires password
     */
    public function test_admin_login_requires_password(): void
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test admin can logout
     */
    public function test_admin_can_logout(): void
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }

    /**
     * Test authenticated admin cannot access login page
     */
    public function test_authenticated_admin_cannot_access_login_page(): void
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.login'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Test inactive admin cannot login
     */
    public function test_inactive_admin_cannot_login(): void
    {
        Admin::create([
            'name' => 'Inactive Admin',
            'email' => 'inactive@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'is_active' => false,
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('admin');
    }

    /**
     * Test seeded admin account can login
     */
    public function test_seeded_admin_can_login(): void
    {
        // Run the admin seeder
        $this->seed(\Database\Seeders\AdminSeeder::class);

        // Test login with seeded credentials
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated('admin');
    }

    /**
     * Test seeded super admin can login
     */
    public function test_seeded_superadmin_can_login(): void
    {
        // Run the admin seeder
        $this->seed(\Database\Seeders\AdminSeeder::class);

        // Test login with seeded super admin credentials
        $response = $this->post(route('admin.login'), [
            'email' => 'superadmin@example.com',
            'password' => 'superadmin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated('admin');

        // Verify it's the super admin
        $admin = Admin::where('email', 'superadmin@example.com')->first();
        $this->assertEquals('super_admin', $admin->role);
    }
}
