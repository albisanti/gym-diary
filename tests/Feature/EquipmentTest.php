<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    public function test_equipment_creation()
    {
        $response = $this->post('/equipment',[
            'name' => 'Test equipment',
            'description' => 'Testing equipment',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_equipment()
    {
        $response = $this->get('/equipment');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','rs' => []]);
    }

    public function test_equipment_update()
    {
        $response = $this->put('/equipment/1',[
            'name' => 'Test update equipment',
            'notes' => 'This is an updated note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_equipment_delete()
    {
        $response = $this->delete('/equipment');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
