<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function setAdminUser(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);
    }

    public function setNormalUser(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /**
     * A basic feature test example.
     */
    public function test_if_admin_can_see_brands_list(): void
    {
        $this->setAdminUser();
        $response = $this->get(route('admin.brand.index'));

        $response->assertStatus(200);
    }

    public function test_a_user_can_not_see_brands_list(): void
    {
        $this->setNormalUser();
        $response = $this->get(route('admin.brand.index'));

        $response->assertStatus(403);
    }

    public function test_if_admin_can_create_brand(): void
    {
        $this->setAdminUser();

        $response = $this->post(route('admin.brand.store'), [
            'title' => 'Test Brand',
            'status' => 1,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('brands', [
            'title' => 'Test Brand',
            'status' => 1,
        ]);
    }

    public function test_should_not_create_brand_without_title(): void
    {
        $this->setAdminUser();

        $response = $this->post(route('admin.brand.store'), [
            'status' => 1,
        ]);

        $response->assertSessionHasErrors('title');

        $this->assertDatabaseCount('brands', 0);
    }

    public function test_a_normal_user_can_not_create_brand(): void
    {
        $this->setNormalUser();

        $response = $this->post(route('admin.brand.store'), [
            'title' => 'Test Brand',
            'status' => 1,
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseCount('brands', 0);
    }

    public function test_if_admin_can_update_brand(): void
    {
        $this->setAdminUser();

        $brand = Brand::factory()->create();

        $response = $this->patch(route('admin.brand.update', $brand->slug), [
            'title' => 'Updated Brand',
            'status' => 0,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('brands', [
            'title' => 'Updated Brand',
            'status' => 0,
        ]);
    }

    public function test_should_not_update_brand_without_title(): void
    {
        $this->setAdminUser();

        $brand = Brand::factory()->create();

        $response = $this->patch(route('admin.brand.update', $brand->slug), [
            'status' => 0,
        ]);

        $response->assertSessionHasErrors('title');

        $this->assertDatabaseHas('brands', [
            'title' => $brand->title,
            'status' => $brand->status,
        ]);
    }

    public function test_a_normal_user_can_not_update_brand(): void
    {
        $this->setNormalUser();

        $brand = Brand::factory()->create();

        $response = $this->patch(route('admin.brand.update', $brand->slug), [
            'title' => 'Updated Brand',
            'status' => 0,
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('brands', [
            'title' => $brand->title,
            'status' => $brand->status,
        ]);
    }

    public function test_if_admin_can_delete_brand(): void
    {
        $this->setAdminUser();

        $brand = Brand::factory()->create();

        $response = $this->delete(route('admin.brand.destroy', $brand->slug));

        $response->assertStatus(200);

        $this->assertSoftDeleted('brands', [
            'title' => $brand->title,
            'status' => $brand->status,
        ]);
    }

    public function test_a_normal_user_can_not_delete_brand(): void
    {
        $this->setNormalUser();

        $brand = Brand::factory()->create();

        $response = $this->delete(route('admin.brand.destroy', $brand->slug));

        $response->assertStatus(403);

        $this->assertDatabaseHas('brands', [
            'title' => $brand->title,
            'status' => $brand->status,
        ]);
    }
}
