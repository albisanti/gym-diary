<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function Register(Request $request){
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        if($user->save()) {
            event(new Registered($user));
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error','report' => 'Non è stato possibile inserire il nuovo utente'],500);
    }

    public function Login(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
            'token_name' => 'required'
        ]);
        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)) {
            $token = $user->createToken($request->token_name);
            return response()->json(['status' => 'success','token' => $token->plainTextToken]);
        }
        return response()->json(['status' => 'error','report' => 'Utente non esistente o password errata'],401);
    }

    public function VerifyEmail(EmailVerificationRequest $request){
        $request->fulfill();
    }

    public function ResendVerificationNotification(Request $request){
        event(new Registered($request->user()));
    }

    public function SendPasswordReset(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT ? response()->json(['report' => 'Mail inviata correttamente']) : response()->json(['report' => 'Email non inviata, riprovare più tardi'],500);
    }

    public function UpdatePassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET ? response()->json() : response()->json(['report' => 'Non è stato possibile resettare la password'],500);
    }
}
