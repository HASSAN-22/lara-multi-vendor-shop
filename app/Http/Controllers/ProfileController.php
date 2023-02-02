<?php

namespace App\Http\Controllers;

use App\Auxiliary\Uploader\Upload;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
