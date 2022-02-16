<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    public function test_equipment_creation(): int
    {
        $response = $this->put('/api/equipment',[
            'name' => 'Test of equipment',
            'description' => 'Testing equipment',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $findId = json_decode($response->getContent());
        return $findId->id;
    }

    public function test_get_all_equipment()
    {
        $response = $this->get('/api/equipment');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','equipment' => []]);
    }

    /**
     * @depends test_equipment_creation
     */
    public function test_get_equipment(int $id)
    {
        $response = $this->get('/api/equipment/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','equipment' => []]);
    }

    /**
     * @depends test_equipment_creation
     */
    public function test_equipment_update(int $id)
    {
        $response = $this->patch('/api/equipment/'.$id,[
            'name' => 'Test update equipment',
            'notes' => 'This is an updated note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    /**
     * @depends test_equipment_creation
     */
    public function test_equipment_delete(int $id)
    {
        $response = $this->delete('/api/equipment/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
