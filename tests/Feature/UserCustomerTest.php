<?php

namespace Tests\Feature;

use App\Events\UserInvited;
use App\Models\User;
use App\Models\UserCustomer;
use App\Notifications\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCustomerTest extends TestCase
{
    use RefreshDatabase;
    public function test_invite_existing_user_customer(){
        Sanctum::actingAs(User::factory()->create());
        $customer = User::factory()->create();
        $response = $this->put('/api/customer/add', [
            'email' => $customer->email
        ]);
        $response->assertStatus(204);
    }

    public function test_invite_non_existing_user_customer(){
        Event::fake();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->put('/api/customer/add', [
            'email' => 'test@mail.com'
        ]);

        Event::assertDispatched(UserInvited::class);
        $response->assertStatus(204);
    }

    public function test_accept_invitation_customer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $hash = Hash::make($user->id.date('Ymd'));
        $invitation = UserCustomer::factory()->create([
            'customer_id' => $user->id,
            'hash' => $hash
        ]);
        $response = $this->patch('/api/customer/accepted', [
            'id' => $invitation->id,
            'hash' => $hash
        ]);
        $response->assertStatus(204);
    }

    public function test_refuse_invitation_customer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $hash = Hash::make($user->id.date('Ymd'));
        $invitation = UserCustomer::factory()->create([
            'customer_id' => $user->id,
            'hash' => $hash
        ]);
        $response = $this->patch('/api/customer/refused', [
            'id' => $invitation->id,
            'hash' => $hash
        ]);
        $response->assertStatus(204);
    }

    public function test_can_create_user_after_accepted_invitation(){
        $user = User::factory()->create();
        $hash = Hash::make($user->id.date('Ymd'));
        $invitation = UserCustomer::factory()->create([
            'customer_id' => $user->id,
            'hash' => $hash,
            'status' => UserCustomer::STATUS_ACCEPTED
        ]);
        $response = $this->patch('/api/customer/finalize-user',[
            'customer_id' => $user->id,
            'name' => 'test',
            'password' => 'testtest',
            'hash' => $hash
        ]);
        $response->assertStatus(200);
    }

    public function test_cannot_create_user_after_refused_invitation(){
        $user = User::factory()->create();
        $hash = Hash::make($user->id.date('Ymd'));
        $invitation = UserCustomer::factory()->create([
            'customer_id' => $user->id,
            'hash' => $hash,
            'status' => UserCustomer::STATUS_REFUSED
        ]);
        $response = $this->patch('/api/customer/finalize-user',[
            'customer_id' => $user->id,
            'name' => 'test',
            'password' => 'testtest',
            'hash' => $hash
        ]);
        $response->assertStatus(403);
    }

    public function test_remove_user_customer(){
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $invitation = UserCustomer::factory()->create(['user_id' => $user->id]);
        $response = $this->delete('/api/customer/remove', [
            'id' => $invitation->id
        ]);
        $response->assertStatus(204);
    }

    public function test_get_all_customers(){
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        UserCustomer::factory()->count(5)->create(['user_id' => $user->id]);
        //TODO: Creare factory per gestire inviti
        $response = $this->get('/api/customer');
        $response->assertStatus(200);
    }

}
