<?php

namespace App\Http\Controllers;

use App\Auxiliary\Uploader\Upload;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $profile = $user->profile;
        $profile ? $this->authorize('update',$profile) : $this->authorize('create',Profile::class);
        return view('profile.update',compact('profile','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, User $user)
    {
        $profile = $user->profile;
        $profile ? $this->authorize('update',$profile) : $this->authorize('create',Profile::class);
        DB::beginTransaction();
        try{
            $user = auth()->user();
            Profile::updateOrCreate(['user_id'=>$user->id],[
                'shop_name'=>$request->shop_name,
                'address'=>$request->address,
                'city'=>$request->city,
                'province'=>$request->province,
                'plak'=>$request->plak,
                'national_id'=>$request->national_id,
                'avatar'=>Upload::upload($request,'avatar','uploader/avatar',$profile->avatar??'')
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            DB::commit();
            return responseMessage(true,'update');
        }catch (\Exception $e){
            DB::rollBack();
            dd($e);
            return responseMessage(false,'update');
        }

    }

    public function passwordEdit(User $user){
        $this->authorize('passwordUpdate',$user);
        return view('profile.password',compact('user'));
    }

    public function passwordUpdate(Request $request, User $user){
        $request->validate([
            'previous_password'=>['required','string','max:255','min:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $this->authorize('passwordUpdate',$user);

        if(!Hash::check($request->previous_password, $user->password)){
            return responseMessage(false,'update','','previous password is not correct');
        }
        $user->password = Hash::make($request->password);
        return responseMessage($user->save(),'update');
    }
}
