<?php

namespace Tests\Feature;

use App\Models\Macro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MacroTest extends TestCase
{
    use RefreshDatabase;
    public function test_macro_creation(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->put('/api/macro',[
            'name' => 'Test of macro',
            'description' => 'Testing macro'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_macro(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->get('/api/macro');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','macro' => []]);
    }

    public function test_get_macro(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $macro = Macro::factory()->create(['user_id' => $user->id]);
        $response = $this->get('/api/macro/'.$macro->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','macro' => []]);
    }

    public function test_macro_update(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $macro = Macro::factory()->create(['user_id' => $user->id]);
        $response = $this->patch('/api/macro/'.$macro->id,[
            'name' => 'Test update macro',
            'description' => 'This is an updated description'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }


    public function test_macro_delete(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $macro = Macro::factory()->create(['user_id' => $user->id]);
        $response = $this->delete('/api/macro/'.$macro->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
