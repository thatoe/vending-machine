<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase; // Resets database after each test

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
    }

    /** @test */
    public function an_admin_can_create_a_product()
    {
        $admin = User::factory()->create(); // Create an admin user
        $admin->assignRole('admin'); // Assign admin role

        $this->actingAs($admin) // Authenticate as admin
            ->post('/products', [
                'name' => 'Coke',
                'price' => 3.99,
                'quantity_available' => 10,
            ])
            ->assertRedirect('/products'); // Ensure redirection after successful creation

        $this->assertDatabaseHas('products', ['name' => 'Coke']); // Check if product exists in DB
    }

    /** @test */
    public function a_user_cannot_create_a_product()
    {
        $user = User::factory()->create(); // Create a user
        $user->assignRole('user'); // Assign user role

        $this->actingAs($user)
            ->post('/products', [
                'name' => 'Coke',
                'price' => 3.99,
                'quantity_available' => 10,
            ])
            ->assertForbidden(); // Ensure forbidden response for non-admin users
    }

    /** @test */
    public function a_product_requires_a_name_price_and_quantity()
    {
        $admin = User::factory()->create(); // Create an admin user
        $admin->assignRole('admin'); // Assign admin role

        $this->actingAs($admin)
            ->post('/products', [])
            ->assertSessionHasErrors(['name', 'price', 'quantity_available']); // Ensure validation errors
    }

    /** @test */
    public function an_admin_can_update_a_product()
    {
        $admin = User::factory()->create(); // Create an admin user
        $admin->assignRole('admin'); // Assign admin role
        $product = Product::create(['name' => 'Pepsi', 'price' => 4.99, 'quantity_available' => 20]);

        $this->actingAs($admin)
            ->put("/products/{$product->id}", ['name' => 'Pepsi Updated', 'price' => 5, 'quantity_available' => 15])
            ->assertRedirect('/products');

        $this->assertDatabaseHas('products', ['name' => 'Pepsi Updated']);
    }

    /** @test */
    public function a_user_cannot_update_a_product()
    {
        $user = User::factory()->create(); // Create a user
        $user->assignRole('user'); // Assign user role
        $product = Product::create(['name' => 'Pepsi', 'price' => 4.99, 'quantity_available' => 20]);

        $this->actingAs($user)
            ->put("/products/{$product->id}", ['name' => 'Pepsi Updated', 'price' => 5, 'quantity_available' => 15])
            ->assertForbidden(); // Ensure forbidden response for non-admin users
    }

    /** @test */
    public function an_admin_can_delete_a_product()
    {
        $admin = User::factory()->create(); // Create an admin user
        $admin->assignRole('admin'); // Assign admin role
        $product = Product::create(['name' => 'Water', 'price' => 4.99, 'quantity_available' => 20]);

        $this->actingAs($admin)
            ->delete("/products/{$product->id}")
            ->assertRedirect('/products');

        $this->assertDatabaseMissing('products', ['name' => 'Water']);
    }

    /** @test */
    public function a_user_cannot_delete_a_product()
    {
        $user = User::factory()->create(); // Create a user
        $user->assignRole('user'); // Assign user role
        $product = Product::create(['name' => 'Water', 'price' => 4.99, 'quantity_available' => 20]);

        $this->actingAs($user)
            ->delete("/products/{$product->id}")
            ->assertForbidden(); // Ensure forbidden response for non-admin users
    }
}
