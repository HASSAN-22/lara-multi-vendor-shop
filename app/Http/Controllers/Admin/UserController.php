<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',User::class);
        $users = User::latest()->search()->paginate(config('app.paginate'));
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',User::class);
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create',User::class);
        $user = $this->updateAndCreate($request,new User());
        return responseMessage($user,'create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('admin.user.update',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update',$user);
        $user = $this->updateAndCreate($request,$user,true);
        return responseMessage($user,'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete',$user);
        return responseMessage($user->delete(),'delete');
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @param bool $isUpdate
     * @return bool
     */
    private function updateAndCreate(UserRequest $request, User $user, bool $isUpdate=false){
        $user->name = $request->name;
        $user->access = $request->access;
        $user->status = $request->status;
        $user->email = $request->email;
        $user->password = ($isUpdate and is_null($request->password)) ? $user->password : Hash::make($request->password);
        return $user->save();
    }
}
