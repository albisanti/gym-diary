<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\UserCustomer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreUserAfterInvitationRequest extends FormRequest
{
    private $user;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = UserCustomer::where('hash',$this->hash)->first();
        if($this->customer_id === (int)$user->customer_id && $user->status === UserCustomer::STATUS_ACCEPTED){
            $this->user = $user;
            return true;
        }
        return false;
    }

    public function fullfill(){
        $user = User::find($this->customer_id);
        $user->name = $this->name;
        $user->password = Hash::make($this->password);
        $user->email_verified_at = now();
        if($user->save()){
            //TODO: dispatch event for notify the user that the invitation has been accepted
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }
}
