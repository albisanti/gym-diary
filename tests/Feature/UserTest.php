<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;
use Illuminate\Auth\Events\Registered;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_register_user()
    {
        Event::fake();
        $response = $this->post('/api/register',[
            'name' => 'Test Dev',
            'email' => 'test@mail.dev',
            'password' => 'password',
        ]);
        $response->assertStatus(200);
        Event::assertDispatched(Registered::class);
    }

    public function test_login_user(){
        $user = User::factory()->create();
        $response = $this->post('/api/login',[
            'email' => $user->email,
            'password' => 'password',
            'token_name' => 'test_token'
        ]);
        $response->assertJsonStructure(['status', 'token'])
            ->assertStatus(200);
    }

    public function test_forgot_password(){
        $user = User::factory()->create();
        Notification::fake();
        $response = $this->post('/api/forgot-password',[
            'email' => $user->email
        ]);
        Notification::assertSentTo([$user],ResetPassword::class);
        $response->assertStatus(200);
    }

    public function test_reset_password(){
        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $response = $this->withoutExceptionHandling()->post('/api/reset-password',[
            'token' => $token,
            'email' => $user->email,
            'password' => 'test1234567.',
            'password_confirmation' => 'test1234567.',
        ]);
        $response->assertStatus(200);
    }

    public function test_email_verification(){
        Event::fake();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->post('/api/email/verification-notification',[
            'email' => $user->email
        ]);
        $response->assertStatus(200);
        Event::assertDispatched(Registered::class);
    }
}
