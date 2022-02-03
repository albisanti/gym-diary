<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MacroTest extends TestCase
{
    public function test_macro_creation(): int
    {
        $response = $this->put('/api/macro',[
            'name' => 'Test of macro',
            'description' => 'Testing macro'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $findId = json_decode($response->getContent());
        return $findId->id;
    }

    public function test_get_all_macro()
    {
        $response = $this->get('/api/macro');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','macro' => []]);
    }

    /**
     * @depends test_macro_creation
     */
    public function test_get_macro(int $id)
    {
        $response = $this->get('/api/macro/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','macro' => []]);
    }

    /**
     * @depends test_macro_creation
     */
    public function test_macro_update(int $id)
    {
        $response = $this->patch('/api/macro/'.$id,[
            'name' => 'Test update macro',
            'description' => 'This is an updated description'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }


    /**
     * @depends test_macro_creation
     */
    public function test_macro_delete(int $id)
    {
        $response = $this->delete('/api/macro/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
