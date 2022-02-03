<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MacroTest extends TestCase
{
    public function test_macro_creation()
    {
        $response = $this->post('/macro',[
            'name' => 'Test equipment',
            'description' => 'Testing equipment',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_macro()
    {
        $response = $this->get('/macro');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','rs' => []]);
    }

    public function test_macro_update()
    {
        $response = $this->put('/macro/1',[
            'name' => 'Test update macro',
            'description' => 'This is an updated description'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_macro_delete()
    {
        $response = $this->delete('/macro');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
