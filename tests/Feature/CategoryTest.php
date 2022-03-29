<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_category_creation(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->put('/api/category',[
            'name' => 'Test of a category',
            'description' => 'Testing category',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_category(): void
    {
        $user = User::factory()->create();
        $response = $this->get('/api/category');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','category' => []]);
    }

    public function test_get_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $response = $this->get('/api/category/'.$category->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','category' => []]);
    }

    public function test_category_update(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $response = $this->patch('/api/category/'.$category->id,[
            'name' => 'Test update category',
            'description' => 'This is an updated description'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_category_delete(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $response = $this->delete('/api/category/'.$category->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
