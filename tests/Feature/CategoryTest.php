<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_creation(): int
    {
        $response = $this->put('/api/category',[
            'name' => 'Test of a category',
            'description' => 'Testing category',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $findId = json_decode($response->getContent());
        return $findId->id;
    }

    public function test_get_all_category()
    {
        $response = $this->get('/api/category');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','category' => []]);
    }

    /**
     * @depends test_category_creation
     */
    public function test_get_category(int $id)
    {
        $response = $this->get('/api/category/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','category' => []]);
    }

    /**
     * @depends test_category_creation
     */
    public function test_category_update(int $id)
    {
        $response = $this->patch('/api/category/'.$id,[
            'name' => 'Test update category',
            'description' => 'This is an updated description'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    /**
     * @depends test_category_creation
     */
    public function test_category_delete(int $id)
    {
        $response = $this->delete('/api/category/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
