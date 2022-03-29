<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;
    public function test_equipment_creation(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->put('/api/equipment',[
            'name' => 'Test of equipment',
            'description' => 'Testing equipment',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_equipment(): void
    {
        $response = $this->get('/api/equipment');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','equipment' => []]);
    }

    public function test_get_equipment(): void
    {
        $user = User::factory()->create();
        $equipment = Equipment::factory()->create(['user_id' => $user->id]);
        $response = $this->get('/api/equipment/'.$equipment->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','equipment' => []]);
    }

    public function test_equipment_update(): void
    {
        $user = User::factory()->create();
        $equipment = Equipment::factory()->create(['user_id' => $user->id]);
        $response = $this->patch('/api/equipment/'.$equipment->id,[
            'name' => 'Test update equipment',
            'notes' => 'This is an updated note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_equipment_delete(): void
    {
        $user = User::factory()->create();
        $equipment = Equipment::factory()->create(['user_id' => $user->id]);
        $response = $this->delete('/api/equipment/'.$equipment->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
