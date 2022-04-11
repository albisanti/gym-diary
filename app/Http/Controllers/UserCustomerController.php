<?php

namespace App\Http\Controllers;

use App\Events\UserInvited;
use App\Http\Requests\StoreUserAfterInvitationRequest;
use App\Models\User;
use App\Models\UserCustomer;
use App\Notifications\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nette\NotImplementedException;

class UserCustomerController extends Controller
{
    public function AddNewCustomer(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $invitation = new UserCustomer;
            $invitation->user_id = Auth::id();
            $invitation->customer_id = $user->id;
            if ($invitation->save()) {
                return response()->noContent();
            }
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        $user = new User;
        $user->email = $request->email;
        if ($user->save()) {
            $hash = Hash::make($user->email . date('Ymd'));
            $invitation = new UserCustomer;
            $invitation->user_id = Auth::id();
            $invitation->customer_id = $user->id;
            $invitation->hash = $hash;
            if ($invitation->save()) {
                $url = $invitation->id . '/' .$hash ;
                event(new UserInvited($user, $url));
                return response()->noContent();
            }
            return response()->json(['warning' => 'User saved but no email has been sent'], 500);
        }
        return response()->json(['error' => 'Something went wrong'], 500);
    }

    public function AcceptOrRefuseInvitation(Request $request){
        $this->validate($request,[
            'id'=>'required|integer',
            'hash' => 'required|string',
        ]);
        $invitation = UserCustomer::find($request->id);
        if($invitation && $invitation->hash === $request->hash){
            $invitation->status = $request->accepted;
            if($invitation->save()){
                return response()->noContent();
            }
            return response()->json(['error'=>'Something went wrong'],500);
        }
        return response()->json(['error'=>'Invitation not found'],404);
    }

    public function FinalizeUserCreation(StoreUserAfterInvitationRequest $request){
        $request->fullfill();
    }

    public function DeleteCustomer(Request $request){
        $invitation = UserCustomer::find($request->id);
        if($invitation){
            if($invitation->delete()){
                return response()->noContent();
            }
            return response()->json(['error'=>'Something went wrong'],500);
        }
        return response()->json(['error'=>'Invitation not found'],404);
    }

    public function GetCustomers(Request $request){
        $customers = User::find(Auth::id())->customers()->get();
        if($customers){
            return response()->json($customers);
        }
        return response()->json(['error'=>'Nessun cliente trovato']);
    }

}
